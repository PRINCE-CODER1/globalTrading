<?php

namespace App\Livewire\InvManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class Sales extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedSales = [];
    public $saleIdToDelete = null;
    public $sortBy = 'created_at';
    public $sortDir = 'asc';

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
    }

    public function render()
    {
        $userId = Auth::id();

        $sales = Sale::query()
            ->with('user') 
            ->where('user_id', $userId)
            ->where('sale_no', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.inv-management.sales', compact('sales'));
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
            $this->selectedSales = Sale::pluck('id')->toArray();
        } else {
            $this->selectedSales = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->saleIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->saleIdToDelete) {
            Sale::find($this->saleIdToDelete)->delete();
            $this->saleIdToDelete = null;
        } elseif ($this->selectedSales) {
            Sale::whereIn('id', $this->selectedSales)->delete();
            $this->selectedSales = [];
        }
        toastr()->closeButton(true)->success('Sale Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedSales)) {
            Sale::whereIn('id', $this->selectedSales)->delete();
            $this->selectedSales = [];
        }
        toastr()->closeButton(true)->success('Sales Deleted Successfully');
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
