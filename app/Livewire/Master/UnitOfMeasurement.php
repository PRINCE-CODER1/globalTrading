<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UnitOfMeasurement as UnitMeasure;
use Illuminate\Support\Facades\Gate;

class UnitOfMeasurement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $sortBy = 'symbol';
    public $sortDir = 'asc'; 
    public $selectedUnitIds = [];
    public $selectAll = false;   
    public $deleteId = null;
    protected $listeners = ['deleteUnit' => 'deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
        // $this->sortBy = session()->get('sortBy', 'symbol');
        // $this->sortDir = session()->get('sortDir', 'asc');
    }

    public function render()
    {
           // Ensure $sortBy is a valid column name
        $validSortColumns = ['symbol', 'formula_name', 'decimal_places'];
        if (!in_array($this->sortBy, $validSortColumns)) {
            $this->sortBy = 'symbol'; 
        }
        $units = UnitMeasure::orderBy($this->sortBy, $this->sortDir)
                            ->where('symbol', 'like', '%' . $this->search . '%')
                            ->paginate($this->perPage);

        return view('livewire.master.unit-of-measurement', ['units' => $units]);
    }

    public function updatedSearch($value)
    {
        session()->put('search', $value);
        $this->resetPage();
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
        $this->resetPage();
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
        session()->flash('success', 'Units Deleted Successfully.');
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->deleteId) {
            UnitMeasure::find($this->deleteId)->delete();
            toastr()->closeButton(true)->success('Units Deleted Successfully.');
            $this->deleteId = null;
            $this->resetPage();
        }
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
}
