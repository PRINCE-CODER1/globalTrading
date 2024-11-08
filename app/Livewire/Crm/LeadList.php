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

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
        $this->statusFilter = session()->get('statusFilter', '');
        $this->userId = Auth::user()->id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user(); // Get the logged-in user
    
        // If the user is a manager
        if ($user->hasRole('Manager')) {
            // Assuming managers are assigned to teams and agents are assigned to teams
            // Get all teams the manager is associated with
            $teamIds = $user->teams->pluck('id')->toArray(); // Get teams for manager
    
            // Get leads assigned to agents in those teams and also leads created by the manager
            $leads = Lead::with('assignedAgent.teams', 'creator') // Eager load the teams relationship
                        ->where(function ($query) use ($teamIds, $user) {
                            // Leads assigned to agents in the manager's teams
                            $query->whereHas('assignedAgent', function ($query) use ($teamIds) {
                                $query->whereIn('team_id', $teamIds); // Filter by teams the manager oversees
                            })
                            // OR leads created by the manager
                            ->orWhere('user_id', $user->id); // Assuming 'created_by' stores the creator of the lead
                        })
                        ->where(function ($query) {
                            $query->whereHas('customer', function ($q) {
                                $q->where('name', 'like', '%' . $this->search . '%');
                            })
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
        } else {
            // If the user is an agent, show only leads assigned to them
            $leads = Lead::with('assignedAgent.teams', 'creator') // Eager load the teams relationship
                        ->where('assigned_to', $this->userId == 0 ? $user->id : $this->userId)
                        ->where(function ($query) {
                            $query->whereHas('customer', function ($q) {
                                $q->where('name', 'like', '%' . $this->search . '%');
                            })
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
        }
    
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