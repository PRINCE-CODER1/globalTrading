<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UnitOfMeasurement as UnitMeasure;
use Illuminate\Support\Facades\Gate;

class UnitOfMeasurement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $sortBy = 'created_at';
    public $sortDir = 'DESC'; 
    public $selectedUnitIds = [];
    public $selectAll = false;  
    protected $listeners = ['deleteUnit' => 'deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
        $this->sortBy = session()->get('sortBy', 'symbol');
        $this->sortDir = session()->get('sortDir', 'asc');
    }
    public function render()
    {
        $units = UnitMeasure::orderBy($this->sortBy, $this->sortDir)
                    ->where('symbol', 'like', '%' . $this->search . '%')
                    ->orWhere('formula_name', 'like', '%' . $this->search . '%')
                    ->paginate($this->perPage);

        return view('livewire.unit-of-measurement', ['units' => $units]);
    }
    public function updatedSearch($value)
    {
        session()->put('search', $value); 
    }
    public function checkPermission($permission)
    {
        return Gate::allows($permission);
    }

    public function updatePerPage($value)
    {
        $this->perPage = $value;
        session()->put('perPage', $this->perPage);
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

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedUnitIds = UnitMeasure::pluck('id')->toArray();
        } else {
            $this->selectedUnitIds = [];
        }
    }

    public function bulkDelete()
    {
        UnitMeasure::whereIn('id', $this->selectedUnitIds)->delete();
        $this->selectedUnitIds = [];
        toastr()->closeButton(true)->success('Units Deleted Successfully.');
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->selectedUnitIds = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->selectedUnitIds) {
            UnitMeasure::find($this->selectedUnitIds)->delete();
            toastr()->closeButton(true)->success('Unit Deleted Successfully.');
            $this->selectedUnitIds = null;
            $this->resetPage();
        }
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
}
