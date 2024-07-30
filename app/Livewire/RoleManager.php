<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleManager extends Component
{
    use WithPagination;

    public $name;
    public $roleId;
    public $permissions = [];
    public $selectedPermissions = [];
    public $selectedLeadSources = [];
    public $search = '';
    public $permissionId = '';
    public $selectAll = false;
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';
    public $perPage = 5;

    public function updatePerPage($value)
    {
        $this->perPage = $value;
        $this->resetPage();
    }
    public function setSortBy($sortByField){
        if ($this->sortBy === $sortByField) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $sortByField;
            $this->sortDir = 'asc';
        }
    }
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedLeadSources = Role::pluck('id')->toArray();
        } else {
            $this->selectedLeadSources = [];
        }
    }
    public function bulkDelete()
    {
        Role::whereIn('id', $this->selectedLeadSources)->delete();
        $this->selectedLeadSources = [];
        toastr()->closeButton(true)->success('Roles Deleted Successfully.');
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->permissionId = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->permissionId) {
            Role::find($this->permissionId)->delete();
            toastr()->closeButton(true)->success('Role Deleted Successfully.');
            $this->permissionId = null;
            $this->resetPage();
        }
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->permissions = Permission::orderBy('name', 'ASC')->get();
        $roles = Role::orderBy($this->sortBy,$this->sortDir)->where('name', 'like', '%' . $this->search . '%')->paginate($this->perPage);

        return view('livewire.role-manager', compact('roles'));
    }
}
