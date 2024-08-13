<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SaleType;


class SaleTypes extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDir = 'desc';
    public $selectAll = false;
    public $selectedSaleTypes = [];
    public $saleTypeIdToDelete = null;

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
        $saleTypes = SaleType::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.master.sale-types', compact('saleTypes'));
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
            $this->selectedSaleTypes = SaleType::pluck('id')->toArray();
        } else {
            $this->selectedSaleTypes = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->saleTypeIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->saleTypeIdToDelete) {
            SaleType::find($this->saleTypeIdToDelete)->delete();
            $this->saleTypeIdToDelete = null;
        } elseif (!empty($this->selectedSaleTypes)) {
            SaleType::whereIn('id', $this->selectedSaleTypes)->delete();
            $this->selectedSaleTypes = [];
        }
        toastr()->closeButton(true)->success('Sale Types Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedSaleTypes)) {
            SaleType::whereIn('id', $this->selectedSaleTypes)->delete();
            $this->selectedSaleTypes = [];
        }
        toastr()->closeButton(true)->success('Sale Types Deleted Successfully');
        $this->resetPage();
    }
    public function setSortBy($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
        session()->put('sortBy', $this->sortBy);
        session()->put('sortDir', $this->sortDir);
    }
}
