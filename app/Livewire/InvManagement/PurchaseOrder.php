<?php

namespace App\Livewire\InvManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PurchaseOrder as PurchaseOrders;
use Illuminate\Support\Facades\Auth;

class PurchaseOrder extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectAll = false;
    public $selectedOrders = [];
    public $orderIdToDelete = null;
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

        $purchaseOrders = PurchaseOrders::with(['supplier', 'customer', 'agent', 'segment', 'orderBranch', 'deliveryBranch', 'user','items'])
            ->where('user_id', $userId)
            ->where(function ($query) {
                $query->where('purchase_order_no', 'like', '%' . $this->search . '%')
                      ->orWhere('supplier_sale_order_no', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.inv-management.purchase-order', compact('purchaseOrders'));
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
            $this->selectedOrders = PurchaseOrders::pluck('id')->toArray();
        } else {
            $this->selectedOrders = [];
        }
    }

    public function confirmDelete($id)
    {
        $this->orderIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->orderIdToDelete) {
            PurchaseOrders::find($this->orderIdToDelete)->delete();
            $this->orderIdToDelete = null;
        } elseif ($this->selectedOrders) {
            PurchaseOrders::whereIn('id', $this->selectedOrders)->delete();
            $this->selectedOrders = [];
        }
        toastr()->closeButton(true)->success('Purchase Order Deleted Successfully');
        $this->resetPage();
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedOrders)) {
            PurchaseOrders::whereIn('id', $this->selectedOrders)->delete();
            $this->selectedOrders = [];
        }
        toastr()->closeButton(true)->success('Purchase Orders Deleted Successfully');
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
