<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BranchManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $sortBy = 'created_at';
    public $sortDir = 'asc';
    public $selectedBranches = [];
    public $branchIdToDelete = null;

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
        // $this->sortBy = session()->get('sortBy', 'created_at');
        // $this->sortDir = session()->get('sortDir', 'asc');
    }

    public function render()
    {
        $branches = Branch::with('user')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        $users = User::all();

        return view('livewire.master.branch-management', compact('branches', 'users'));
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
            $this->selectedBranches = Branch::pluck('id')->toArray();
        } else {
            $this->selectedBranches = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->branchIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->branchIdToDelete) {
            Branch::find($this->branchIdToDelete)->delete();
            $this->branchIdToDelete = null;
        } elseif ($this->selectedBranches) {
            Branch::whereIn('id', $this->selectedBranches)->delete();
            $this->selectedBranches = [];
        }
        toastr()->closeButton(true)->success('Branch Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedBranches)) {
            Branch::whereIn('id', $this->selectedBranches)->delete();
            $this->selectedBranches = [];
        }
        toastr()->closeButton(true)->success('Branches Deleted Successfully');
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
