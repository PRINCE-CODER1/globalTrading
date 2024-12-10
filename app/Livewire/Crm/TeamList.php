<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Team;

class TeamList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedTeams = [];
    public $teamIdToDelete = null;
    public $sortBy = 'created_at';
    public $sortDir = 'asc';
    public $showDeleteModal = false; // Used to handle modal visibility

    protected $listeners = ['deleteConfirmed'];
    protected $updatesQueryString = ['search', 'sortBy', 'sortDir', 'perPage'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
        // $this->sortBy = session()->get('sortBy', 'created_at');
        // $this->sortDir = session()->get('sortDir', 'asc');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();
        
        $teams = Team::where('creator_id', $user->id)
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.crm.team-list', compact('teams'));
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
            $this->selectedTeams = Team::pluck('id')->toArray();
        } else {
            $this->selectedTeams = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->teamIdToDelete = $id;
        $this->showDeleteModal = true; 
    }

    public function deleteConfirmed()
    {
        if ($this->teamIdToDelete) {
            Team::find($this->teamIdToDelete)->delete();
            toastr()->closeButton(true)->success('Team Deleted Successfully');
            $this->teamIdToDelete = null;
        }

        $this->resetPage();
        $this->showDeleteModal = false; // Close delete confirmation modal
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedTeams)) {
            Team::whereIn('id', $this->selectedTeams)->delete();
            $this->selectedTeams = [];
            toastr()->closeButton(true)->success('Teams Deleted Successfully');
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
        $this->resetPage();
    }

    public function closeModal()
    {
        $this->showDeleteModal = false; // To manually close the modal
    }
}
