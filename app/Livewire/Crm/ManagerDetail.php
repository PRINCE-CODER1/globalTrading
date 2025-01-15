<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Team;
use App\Models\Lead;
use App\Models\LeadStatus;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeadsExport;

class ManagerDetail extends Component
{
    use WithPagination;

    public $managerId;
    public $search = '';
    public $teamFilter = '';
    public $statusFilter = '';
    public $startDate = '';
    public $endDate = '';
    public $sortBy = 'created_at';
    public $sortDir = 'desc';
    public $perPage = 10;
    public $statuses;
    public $selectedLeads = [];  // Initialize selected leads array
    public $selectAll = false;   // Add selectAll property for bulk selection
    public $leadIdToDelete = null;  // Store the lead ID to delete

    public function mount($managerId)
    {
        $this->managerId = $managerId;
        $this->statuses = LeadStatus::all();
        if (!auth()->user()->hasRole(['Manager', 'Admin'])) {
            abort(403, 'Unauthorized access');
        }
    }

    public function resetFilters()
    {
        // Reset filter properties
        $this->search = '';
        $this->teamFilter = '';
        $this->statusFilter = '';
        $this->startDate = '';
        $this->endDate = '';
    }

    public function updatePerPage($perPage)
    {
        $this->perPage = $perPage;
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        // Select or unselect all leads based on the 'selectAll' checkbox
        $this->selectedLeads = $value ? Lead::pluck('id')->toArray() : [];
    }
    public function exportLeads($type = 'xlsx')
    {   
        $user = Auth::user();
        $filteredLeads = $this->filteredLeadsQuery($user)
        ->where('assigned_to', $this->managerId) 
        ->get();

        $date = now()->format('Y_m_d');

        if ($type === 'xlsx') {
            return Excel::download(new LeadsExport($filteredLeads), "lead_report_{$date}.xlsx");
        } elseif ($type === 'csv') {
            return Excel::download(new LeadsExport($filteredLeads), "lead_report_{$date}.csv");
        } else {
            return redirect()->back()->with('error', 'Invalid file type selected.');
        }
    }
    private function filteredLeadsQuery()
    {
        return Lead::with(['customer', 'leadStatus', 'assignedAgent', 'leadSource', 'remarks'])
            ->when($this->search, function ($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('reference_id', 'like', '%' . $this->search . '%');
            })
            ->when($this->teamFilter, function ($query) {
                $query->whereHas('assignedAgent.teams', function ($q) {
                    $q->where('name', 'like', '%' . $this->teamFilter . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->whereHas('leadStatus', function ($q) {
                    $q->where('name', $this->statusFilter);
                });
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            });
    }
    
    public function render()
    {
        // Retrieve the manager details
        $manager = User::findOrFail($this->managerId);

        // Get the manager's teams (not needed for the leads directly assigned to the manager)
        $teams = Team::with('agents')->where('creator_id', $this->managerId)->get();

        $leads = $this->filteredLeadsQuery()
            ->where('assigned_to', $this->managerId)
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        // Count manager leads (leads directly assigned to the manager)
        $managerLeadsCount = Lead::where('assigned_to', $this->managerId)
            ->count();

        return view('livewire.crm.manager-detail', [
            'leads' => $leads,
            'manager' => $manager,
            'teams' => $teams,
            'managerLeadsCount' => $managerLeadsCount
        ]);
    }

    

    public function confirmDelete($id)
    {
        $this->leadIdToDelete = $id;
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
                    "Lead with ID {$lead->id} and name {$lead->name} was deleted by " . auth()->user()->name
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
                        "Lead with ID {$lead->id} and name {$lead->name} was deleted by " . auth()->user()->name
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
}
