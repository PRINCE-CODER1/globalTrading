<?php

namespace App\Livewire\InvManagement;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CustomerSupplier;
use App\Models\Purchase;
use App\Models\Branch;
use App\Models\Godown;
use App\Models\Product;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Auth;

class PurchaseEdit extends Component
{
    use WithFileUploads;

    public $purchase, $supplier_id, $purchase_date, $branch_id, $purchase_order_id, $ref_no;
    public $items = [];
    public $supplier_sale_order_no;
    public $supplierSaleOrderNos = [];
    public $purchaseOrders, $suppliers, $branches, $products, $godowns;

    public function mount($purchaseId)
    {
        // Fetch the existing purchase data
        $this->purchase = Purchase::with('items.product')->findOrFail($purchaseId);

        // Initialize properties based on the existing purchase
        $this->supplier_id = $this->purchase->supplier_id;
        $this->purchase_date = $this->purchase->purchase_date;
        $this->branch_id = $this->purchase->branch_id;
        $this->purchase_order_id = $this->purchase->purchase_order_id;
        $this->supplier_sale_order_no = $this->purchase->supplier_sale_order_no;
        $this->ref_no = $this->purchase->ref_no;
        
        // Initialize items with the existing purchase items
        $this->items = $this->purchase->items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'discount' => $item->discount,
                'godown_id' => $item->godown_id,
                'sub_total' => $item->sub_total,
            ];
        })->toArray();

        // Initialize additional properties
        $this->suppliers = CustomerSupplier::where('customer_supplier', 'onlySupplier')->get();
        $this->branches = Branch::all();
        $this->products = Product::all();
        $this->godowns = Godown::where('branch_id', $this->branch_id)->get();
        $this->purchaseOrders = PurchaseOrder::where('supplier_id', $this->supplier_id)->get();
        $this->supplierSaleOrderNos = PurchaseOrder::where('supplier_id', $this->supplier_id)
                                                   ->pluck('supplier_sale_order_no', 'id')
                                                   ->toArray();
    }

    // Fetch items based on Purchase Order ID
    public function updatedPurchaseOrderId($purchaseOrderId)
    {
        $this->fetchItems($purchaseOrderId, 'purchase_order_id');
    }

    // Fetch items based on Supplier Sale Order No
    public function updatedSupplierSaleOrderNo($supplierSaleOrderNo)
    {
        $this->fetchItems($supplierSaleOrderNo, 'supplier_sale_order_no');
    }

    // Fetch items based on order ID
    private function fetchItems($orderId, $type)
    {
        $purchaseOrder = PurchaseOrder::with('items.product')->find($orderId);

        if ($purchaseOrder) {
            $this->items = $purchaseOrder->items->map(function ($item) {
                $subTotal = $item->quantity * $item->price;
                $discountAmount = ($item->discount / 100) * $subTotal;
                return [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'discount' => $item->discount,
                    'godown_id' => $item->godown_id,
                    'sub_total' => $subTotal - $discountAmount,
                ];
            })->toArray();
        } else {
            $this->items = [];
        }
    }

    // Update godowns based on the selected branch
    public function updatedBranchId($branchId)
    {
        $this->godowns = Godown::where('branch_id', $branchId)->get();
        foreach ($this->items as &$item) {
            $item['godown_id'] = null;
        }
    }

    // Update item subtotals dynamically
    public function updated($attribute)
    {
        if (preg_match('/^items\.(\d+)\.(.+)$/', $attribute, $matches)) {
            $index = $matches[1] ?? null;
            if (isset($this->items[$index])) {
                $this->updateSubTotal($index);
            }
        }
    }

    // Function to update the subtotal of an item
    public function updateSubTotal($index)
    {
        $item = &$this->items[$index];
        $quantity = floatval($item['quantity'] ?? 0);
        $price = floatval($item['price'] ?? 0);
        $discount = floatval($item['discount'] ?? 0);

        // Calculate subtotal and apply discount
        $subTotal = $quantity * $price;
        $discountAmount = ($discount / 100) * $subTotal;

        $item['sub_total'] = $subTotal - $discountAmount;
    }

    // Add a new item to the list
    public function addItem()
    {
        $this->items[] = $this->initializeItem();
    }

    // Remove an item from the list
    public function removeItem($index)
    {
        if (isset($this->items[$index])) {
            unset($this->items[$index]);
            $this->items = array_values($this->items); // Re-index the array
        }
    }

    // Initialize item
    private function initializeItem()
    {
        return [
            'product_id' => null,
            'quantity' => 1,
            'price' => 0,
            'discount' => 0,
            'godown_id' => null,
            'sub_total' => 0,
        ];
    }

    // Save the updated purchase and its items
    public function update()
    {
        $this->validate([
            'supplier_id' => 'required|exists:customer_suppliers,id',
            'purchase_date' => 'required|date',
            'branch_id' => 'required|exists:branches,id',
            'purchase_order_id' => 'nullable|exists:purchase_orders,id',
            'supplier_sale_order_no' => 'nullable|exists:purchase_orders,supplier_sale_order_no',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0|max:100',
            'items.*.godown_id' => 'required|exists:godowns,id',
        ]);

        if (!$this->supplier_sale_order_no && !$this->purchase_order_id) {
            toastr()->closeButton(true)->success('Either Supplier Sale Order Number or Purchase Order ID must be filled.');
            return;
        }

        // Update the purchase record
        $this->purchase->update([
            'supplier_id' => $this->supplier_id,
            'purchase_date' => $this->purchase_date,
            'branch_id' => $this->branch_id,
            'purchase_order_id' => $this->purchase_order_id,
            'supplier_sale_order_no' => $this->supplier_sale_order_no,
            'ref_no' => $this->ref_no,
            'user_id' => auth()->id(),
        ]);

        // Update purchase items
        foreach ($this->items as $item) {
            // Add user_id to item data
            $item['user_id'] = Auth::id();

            // Create or update purchase item
            $purchaseItem = $this->purchase->items()->updateOrCreate(
                ['product_id' => $item['product_id'], 'godown_id' => $item['godown_id']],
                $item
            );

            // Update the product's stock in the specific godown
            $product = Product::find($item['product_id']);
            if ($product) {
                // Update the stock based on godown_id
                $product->stock()->where('godown_id', $item['godown_id'])->increment('opening_stock', $item['quantity']);
            }
        }

        toastr()->closeButton(true)->success('Purchase updated successfully!');
        return redirect()->route('purchase.index');
    }

    // Render the component view
    public function render()
    {
        return view('livewire.inv-management.purchase-edit');
    }
}
