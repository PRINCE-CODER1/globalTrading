<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Branch;
use App\Models\User;

class BranchManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedBranches = [];
    public $branchIdToDelete = null;

    protected $listeners = ['deleteConfirmed'];

    public function render()
    {
        $branches = Branch::with('user')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $users = User::all();

        return view('livewire.branch-management', compact('branches', 'users'));
    }

    public function updatePerPage($value)
    {
        $this->perPage = $value;
        $this->resetPage();
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
}
