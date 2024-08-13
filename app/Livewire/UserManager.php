<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;

class UserManager extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $sortBy = 'created_at';
    public $sortDir = 'DESC'; 
    public $name = '';
    public $email = '';
    public $password = '';
    public $roles = [];
    public $selectedUserIds = [];
    public $selectAll = false;  
    public $allRoles = [];
    public $heading = 'User List';
    protected $listeners = ['deleteUser' => 'deleteConfirmed'];

    // Method to check permissions
    public function checkPermission($permission)
    {
        return Gate::allows($permission);
    }

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
            $this->selectedUserIds = User::pluck('id')->toArray();
        } else {
            $this->selectedUserIds = [];
        }
    }
    public function bulkDelete()
    {
        User::whereIn('id', $this->selectedUserIds)->delete();
        $this->selectedUserIds = [];
        toastr()->closeButton(true)->success('Users Deleted Successfully.');
        $this->resetPage();
    }


    public function confirmDelete($id)
    {
        $this->selectedUserIds = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->selectedUserIds) {
            User::find($this->selectedUserIds)->delete();
            toastr()->closeButton(true)->success('User Deleted Successfully.');
            $this->selectedUserIds = null;
            $this->resetPage();
        }
    }


    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::with('roles')->orderBy($this->sortBy, $this->sortDir)
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->paginate($this->perPage);

        return view('livewire.user-manager', ['users' => $users]);
    }
}
