<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Lead;
use App\Models\User;
use App\Models\LeadStatus;
use Illuminate\Support\Facades\Auth;

class LeadList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedLeads = [];
    public $leadIdToDelete = null;
    public $sortBy = 'created_at';
    public $sortDir = 'asc';
    public $statusFilter = '';
    public $totalLeadsForAgent = 0;


    protected $listeners = ['deleteConfirmed'];
    protected $updatesQueryString = ['search'];

    public $userId = 0;

   

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

        // Filter leads
        $leads = Lead::with(['assignedAgent', 'creator']) // Load only necessary relationships
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
            ->when($this->statusFilter, function ($query) {
                $query->whereHas('leadStatus', function ($q) {
                    $q->where('name', $this->statusFilter);
                });
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        $statuses = LeadStatus::all();
        return view('livewire.crm.lead-list', compact('leads', 'statuses'));
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

    public function deleteConfirmed()
    {
        if ($this->leadIdToDelete) {
            Lead::find($this->leadIdToDelete)->delete();
            toastr()->closeButton(true)->success('Lead Deleted Successfully');
            $this->leadIdToDelete = null;
        }

        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedLeads)) {
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