<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class ShowUsers extends Component
{
    use WithPagination;
    public $perPage = 5;
    public $search = '';
    public $userType = '';
    public $sortBy = 'created_at';
    public $sortDir = 'DESC'; 
    public $userIdToDelete = null;

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
    public function render()
    {
        $users = User::orderBy($this->sortBy,$this->sortDir)->where('email', 'like', '%' . $this->search . '%')->paginate($this->perPage);
        if ($this->userType) {
            $query->where('role', $this->userType);
        }
        return view('livewire.show-users',compact('users'));
    }
    public function confirmDelete($id)
    {
        $this->userIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->userIdToDelete) {
            $user = User::find($this->userIdToDelete);
            if ($user) {
                $user->delete();
                session()->flash('message', 'User deleted successfully.');
                $this->userIdToDelete = null;
            }
        }
    }
}
