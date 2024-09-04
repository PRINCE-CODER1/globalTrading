<?php

namespace App\Livewire\InvManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StockTransfer as StockTrans;

class StockTransfer extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $searchTerm = '';
    public $selectAll = false;
    public $selectedStock = [];
    public $stockTransferIdBeingDeleted = null;

    protected $paginationTheme = 'bootstrap';

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedStock = StockTrans::pluck('id')->toArray();
        } else {
            $this->selectedStock = [];
        }
    }

    public function updatePerPage($size)
    {
        $this->perPage = $size;
    }

    public function confirmDelete($id)
    {
        $this->stockTransferIdBeingDeleted = $id;
    }

    public function deleteConfirmed()
    {
        StockTrans::findOrFail($this->stockTransferIdBeingDeleted)->delete();
        $this->stockTransferIdBeingDeleted = null;
        session()->flash('message', 'Stock transfer deleted successfully.');
    }

    public function bulkDelete()
    {
        StockTrans::whereIn('id', $this->selectedStock)->delete();
        $this->selectedStock = [];
        session()->flash('message', 'Selected stock transfers deleted successfully.');
    }

    public function render()
    {
        $stockTransfers = StockTrans::where('stock_transfer_no', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('user_id', 'like', '%'.$this->searchTerm.'%')
            ->paginate($this->perPage);

        return view('livewire.inv-management.stock-transfer', compact('stockTransfers'));
    }
}
