<?php

namespace App\Livewire\InvManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Assembly as assemblies;
use Illuminate\Support\Facades\Auth;

class Assembly extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedAssemblies = [];
    public $assemblyIdToDelete = null;
    public $sortBy = 'created_at';
    public $sortDir = 'asc';

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
        $userId = Auth::id();

        $assemblies = assemblies::with(['product', 'branch', 'godown', 'user'])
            ->where('user_id', $userId)
            ->where('challan_no', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);
        return view('livewire.inv-management.assembly',compact('assemblies'));
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
            $this->selectedAssemblies = assemblies::pluck('id')->toArray();
        } else {
            $this->selectedAssemblies = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->assemblyIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->assemblyIdToDelete) {
            assemblies::find($this->assemblyIdToDelete)->delete();
            $this->assemblyIdToDelete = null;
        } elseif ($this->selectedAssemblies) {
            assemblies::whereIn('id', $this->selectedAssemblies)->delete();
            $this->selectedAssemblies = [];
        }
        toastr()->closeButton(true)->success('Assembly Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedAssemblies)) {
            assemblies::whereIn('id', $this->selectedAssemblies)->delete();
            $this->selectedAssemblies = [];
        }
        toastr()->closeButton(true)->success('Assemblies Deleted Successfully');
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
