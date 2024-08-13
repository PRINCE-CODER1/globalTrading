<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tax;

class Taxes extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;    
    public $sortBy = 'name';
    public $sortDir = 'asc';
    public $selectAll = false;
    public $selectedTaxes = [];
    public $taxIdToDelete = null;
    public $confirmingDelete = false;

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
        // $this->sortBy = session()->get('sortBy', 'name');
        // $this->sortDir = session()->get('sortDir', 'asc');
    }
    public function render()
    {
        $taxes = Tax::with('user')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.master.taxes', compact('taxes'));
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
            $this->selectedTaxes = Tax::pluck('id')->toArray();
        } else {
            $this->selectedTaxes = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->taxIdToDelete = $id;
        $this->confirmingDelete = true;
    }

    public function deleteConfirmed()
    {
        if ($this->taxIdToDelete) {
            Tax::find($this->taxIdToDelete)->delete();
            $this->taxIdToDelete = null;
        } elseif (!empty($this->selectedTaxes)) {
            Tax::whereIn('id', $this->selectedTaxes)->delete();
            $this->selectedTaxes = [];
        }
        toastr()->closeButton(true)->success('Taxes Deleted Successfully');
        $this->confirmingDelete = false;
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedTaxes)) {
            Tax::whereIn('id', $this->selectedTaxes)->delete();
            $this->selectedTaxes = [];
        }
        toastr()->closeButton(true)->success('Taxes Deleted Successfully');
        $this->confirmingDelete = false;
        $this->resetPage();
    }
}
