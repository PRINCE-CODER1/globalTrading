<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Lead;
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

    protected $listeners = ['deleteConfirmed'];
    protected $updatesQueryString = ['search'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
        $this->sortBy = session()->get('sortBy', 'created_at');
        $this->sortDir = session()->get('sortDir', 'asc');
        $this->statusFilter = session()->get('statusFilter', '');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user(); // Get the logged-in user

        // If the user is a manager, they can see all leads
        if ($user->hasRole('Manager')) {
            $leads = Lead::with('assignedAgent.teams') // Eager load the teams relationship
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
            $leads = Lead::with('assignedAgent.teams') // Eager load the teams relationship
                        ->where('assigned_to', $user->id)
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
