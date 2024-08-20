<?php

namespace App\Livewire\InvManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Assembly as Assemblies;
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
    public $selectedAssembly;

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
    }

    public function render()
    {
        $userId = Auth::id();

        // Fetch assemblies with their related models
        $assemblies = Assemblies::with(['product', 'branch', 'godown', 'user'])
            ->where('user_id', $userId)
            ->where('challan_no', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.inv-management.assembly', compact('assemblies'));
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
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Fetch all assembly IDs for selection
            $this->selectedAssemblies = Assemblies::pluck('id')->toArray();
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
            Assemblies::find($this->assemblyIdToDelete)?->delete();
            $this->assemblyIdToDelete = null;
        } elseif (!empty($this->selectedAssemblies)) {
            Assemblies::whereIn('id', $this->selectedAssemblies)->delete();
            $this->selectedAssemblies = [];
        }
        toastr()->closeButton(true)->success('Assembly(s) Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedAssemblies)) {
            Assemblies::whereIn('id', $this->selectedAssemblies)->delete();
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

    public function setSelectedAssembly($assemblyId)
    {
        $this->selectedAssembly = $assemblyId;
    }
}
