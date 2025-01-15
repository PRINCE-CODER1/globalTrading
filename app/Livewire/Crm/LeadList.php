<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Lead;
use App\Models\User;
use App\Models\Team;
use App\Models\LeadStatus;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeadsExport;

class LeadList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $teamFilter = '';
    public $selectAll = false;
    public $selectedLeads = [];
    public $leadIdToDelete = null;
    public $sortBy = 'created_at';
    public $sortDir = 'asc';
    public $statusFilter = '';
    public $totalLeadsForAgent = 0;
    public $startDate;
    public $endDate;


    protected $listeners = ['deleteConfirmed'];

    public $userId = 0;

    public function resetFilters()
    {
        $this->search = '';
        $this->teamFilter = null;
        $this->statusFilter = null;
        $this->startDate = null;
        $this->endDate = null;
    }
    // Listen for filter changes and reset the pagination
    protected $updatesQueryString = ['search', 'statusFilter', 'teamFilter', 'sortBy', 'sortDir', 'perPage'];
    public function exportLeads($type = 'xlsx')
    {
        $user = Auth::user();
        $filteredLeads = $this->filteredQuery($user)->get();

        $date = now()->format('Y_m_d');

        if ($type === 'xlsx') {
            return Excel::download(new LeadsExport($filteredLeads), "lead_report_{$date}.xlsx");
        } elseif ($type === 'csv') {
            return Excel::download(new LeadsExport($filteredLeads), "lead_report_{$date}.csv");
        } else {
            return redirect()->back()->with('error', 'Invalid file type selected.');
        }
    }

    public function mount($userId = 0)
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
        $this->statusFilter = session()->get('statusFilter', '');
        $this->userId = $userId;
        //$this->userId = Auth::user()->id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    // public function render()
    // {
    //     $user = Auth::user(); // Get the logged-in user
    
    //     // Get the leads where the user is either the creator or the assigned agent
    //     $leads = Lead::with('assignedAgent.teams', 'creator') // Eager load relationships
    //         ->where(function ($query) use ($user) {
    //             // Get leads where the user is either the creator or the assigned agent
    //             $query->where('assigned_to', $user->id); // Leads assigned to the user
    //         })
    //         ->where(function ($query) {
    //             $query->whereHas('customer', function ($q) {
    //                 $q->where('name', 'like', '%' . $this->search . '%');
    //             })
    //             ->orWhere('reference_id', 'like', '%' . $this->search . '%')
    //             ->orWhereHas('leadStatus', function ($q) {
    //                 $q->where('name', 'like', '%' . $this->search . '%');
    //             })
    //             ->orWhereHas('leadSource', function ($q) {
    //                 $q->where('name', 'like', '%' . $this->search . '%');
    //             });
    //         })
    //         ->when($this->statusFilter, function ($query) {
    //             $query->whereHas('leadStatus', function ($q) {
    //                 $q->where('name', $this->statusFilter);
    //             });
    //         })
    //         ->orderBy($this->sortBy, $this->sortDir)
    //         ->latest('created_at')
    //         ->paginate($this->perPage);
    
    //     $statuses = LeadStatus::all();
    //     return view('livewire.crm.lead-list', compact('leads', 'statuses'));
    // }
    public function render()
    {
        $user = Auth::user();
        $teams = Team::all();
        // Filter leads
        $leads = $this->filteredQuery($user)->paginate($this->perPage);
        $statuses = LeadStatus::all();
        return view('livewire.crm.lead-list', compact('leads', 'statuses','teams'));
    }
    

    private function filteredQuery($user)
    {
        return Lead::with(['assignedAgent', 'creator']) // Load only necessary relationships
            ->when($this->userId > 0, function ($query) {
                $query->where('assigned_to', $this->userId); // Filter for specific agent
            }, function ($query) use ($user) {
                $query->where('assigned_to', $user->id); // Default to authenticated user
            })
            ->where(function ($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('reference_id', 'like', '%' . $this->search . '%')
                ->orWhereHas('leadStatus', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('leadSource', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->when($this->statusFilter, function ($query) {
                $query->whereHas('leadStatus', function ($q) {
                    $q->where('name', $this->statusFilter);
                });
            })
            ->orderBy($this->sortBy, $this->sortDir);
    }

    

    
    public function updatePerPage($value)
    {
        $this->perPage = $value;
        session()->put('perPage', $this->perPage);
        $this->resetPage();
    }

    public function updatedSearch($value)
    {
        session()->put('search', $value);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedLeads = Lead::pluck('id')->toArray();
        } else {
            $this->selectedLeads = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->leadIdToDelete = $id;
    }

    protected function logLeadAction($lead, $logType, $details)
{
    // Check if the lead exists before inserting the log
    if ($lead) {
        \App\Models\LeadLog::create([
            'lead_id' => $lead->id,
            'id_from' => auth()->id(),
            'id_to' => $lead->assigned_to ?? null,
            'log_type' => $logType,
            'details' => $details,
        ]);
    } else {
        toastr()->error("Lead with ID {$lead->id} does not exist.");
    }
}

public function deleteConfirmed()
{
    if ($this->leadIdToDelete) {
        $lead = Lead::find($this->leadIdToDelete);
        if ($lead) {
            // Log the action before deleting the lead
            $this->logLeadAction(
                $lead,
                'lead_deleted',
                "<strong class='text-danger'>Lead with ID {$lead->id} and customer {$lead->Customer->name} was deleted by </strong>" . auth()->user()->name
            );

            // Now delete the lead
            $lead->delete();
            toastr()->closeButton(true)->success('Lead Deleted Successfully');
        } else {
            toastr()->error('Lead not found.');
        }
        $this->leadIdToDelete = null;
    }

    $this->resetPage();
}

public function bulkDelete()
{
    if (!empty($this->selectedLeads)) {
        $leads = Lead::whereIn('id', $this->selectedLeads)->get();
        
        foreach ($leads as $lead) {
            if ($lead) {
                // Log the action before deleting the lead
                $this->logLeadAction(
                    $lead,
                    'lead_deleted',
                    "<strong class='text-danger'>Lead with ID {$lead->id} and customer {$lead->Customer->name} was deleted by </strong>" . auth()->user()->name
                );
            }
        }

        // Proceed to delete the leads after logging
        Lead::whereIn('id', $this->selectedLeads)->delete();
        $this->selectedLeads = [];
        toastr()->closeButton(true)->success('Leads Deleted Successfully');
    }

    $this->resetPage();
}


    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $sortByField;
            $this->sortDir = 'asc';
        }
        session()->put('sortBy', $this->sortBy);
        session()->put('sortDir', $this->sortDir);
    }
}