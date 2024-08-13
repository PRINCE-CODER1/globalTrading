<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StockAging as StockAgingModel;
use Illuminate\Support\Facades\Auth;

class StockAging extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedAging = [];
    public $stockIdToDelete = null;

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->search = session()->get('search', '');
        $this->perPage = session()->get('perPage', 10);
    }

    public function render()
    {
        $stockAging = StockAgingModel::with(['product'])
            ->where(function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('product_name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('received_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.master.stock-aging', compact('stockAging'));
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
            $this->selectedAging = StockAgingModel::pluck('id')->toArray();
        } else {
            $this->selectedAging = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->stockIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->stockIdToDelete) {
            StockAgingModel::find($this->stockIdToDelete)->delete();
            $this->stockIdToDelete = null;
        } elseif ($this->selectedAging) {
            StockAgingModel::whereIn('id', $this->selectedAging)->delete();
            $this->selectedAging = [];
        }
        toastr()->closeButton(true)->success('Stock Aging Record Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedAging)) {
            StockAgingModel::whereIn('id', $this->selectedAging)->delete();
            $this->selectedAging = [];
        }
        toastr()->closeButton(true)->success('Selected Stock Aging Records Deleted Successfully');
        $this->resetPage();
    }
}
