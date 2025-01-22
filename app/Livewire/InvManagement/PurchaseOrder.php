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
        // Initialize arrays for success and warning messages
        $successMessages = [];
        $warningMessages = [];

        // Retrieve selected purchase orders based on either single ID or multiple IDs
        $purchaseOrders = collect();
        if ($this->orderIdToDelete) {
            $purchaseOrders = PurchaseOrders::where('id', $this->orderIdToDelete)->get();
        } elseif (!empty($this->selectedOrders)) {
            $purchaseOrders = PurchaseOrders::whereIn('id', $this->selectedOrders)->get();
        }

        // Process each purchase order
        foreach ($purchaseOrders as $purchaseOrder) {
            if ($purchaseOrder->purchases()->exists()) {
                $warningMessages[] = "Purchase Order #{$purchaseOrder->purchase_order_no} cannot be deleted because it has related Purchases.";
            } else {
                $purchaseOrder->delete();
                $successMessages[] = "Purchase Order #{$purchaseOrder->purchase_order_no} Deleted Successfully.";
            }
        }

        // Show toastr messages for warnings
        foreach ($warningMessages as $message) {
            toastr()->closeButton(true)->warning($message);
        }

        // Show toastr messages for successes
        foreach ($successMessages as $message) {
            toastr()->closeButton(true)->success($message);
        }

        // Reset selected orders and order ID
        $this->orderIdToDelete = null;
        $this->selectedOrders = [];
        $this->resetPage();
    }

    public function bulkDelete()
    {
        $successMessages = [];
        $warningMessages = [];

        if (!empty($this->selectedOrders)) {
            $purchaseOrders = PurchaseOrders::whereIn('id', $this->selectedOrders)->get();
            
            foreach ($purchaseOrders as $purchaseOrder) {
                // Check if any purchase order has related purchases
                if ($purchaseOrder->purchases()->exists()) {
                    // Accumulate warning message for this purchase order
                    $warningMessages[] = "Purchase Order #{$purchaseOrder->purchase_order_no} cannot be deleted because it has related Purchases.";
                } else {
                    // Delete the purchase order if no related purchases are found
                    $purchaseOrder->delete();
                    // Accumulate success message for this purchase order
                    $successMessages[] = "Purchase Order #{$purchaseOrder->purchase_order_no} deleted successfully.";
                }
            }

            $this->selectedOrders = [];
        }

        // Display toastr messages
        if (!empty($warningMessages)) {
            foreach ($warningMessages as $message) {
                toastr()->closeButton(true)->warning($message);
            }
        }

        if (!empty($successMessages)) {
            foreach ($successMessages as $message) {
                toastr()->closeButton(true)->success($message);
            }
        }

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
