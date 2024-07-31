<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class PermissionManager extends Component
{
    use WithPagination;

    public $sortBy = 'created_at';
    public $sortDir = 'DESC';
    public $perPage = 5;
    public $search = '';
    public $selectAll = false;
    public $permissionId = [];

    public function updatePerPage($value)
    {
        $this->perPage = $value;
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
    }

    public function render()
    {
        $permissionGroups = Permission::orderBy($this->sortBy, $this->sortDir)
        ->where('name', 'like', '%' . $this->search . '%')
        ->get()
        ->groupBy('category');
        $permissions = Permission::orderBy($this->sortBy, $this->sortDir)
            ->where('name', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);

        return view('livewire.permission-manager', compact('permissions','permissionGroups'));
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->permissionId = Permission::pluck('id')->toArray();
        } else {
            $this->permissionId = [];
        }
    }

    public function bulkDelete()
    {
        if (!empty($this->permissionId)) {
            Permission::whereIn('id', $this->permissionId)->delete();
            $this->permissionId = [];
            toastr()->closeButton(true)->success('Selected permissions deleted successfully.');
            $this->resetPage();
        }
    }

    public function confirmDelete($id)
    {
        $this->permissionId = [$id];
    }

    public function deleteConfirmed()
    {
        if (!empty($this->permissionId)) {
            Permission::destroy($this->permissionId);
            toastr()->closeButton(true)->success('Permission deleted successfully.');
            $this->permissionId = [];
            $this->resetPage();
        }
    }
}
