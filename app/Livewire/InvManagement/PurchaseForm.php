<?php

namespace App\Livewire\InvManagement;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerSupplier;
use App\Models\Purchase;
use App\Models\Branch;
use App\Models\Godown;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;

class PurchaseForm extends Component
{
    use WithFileUploads;

    public $supplier_id, $purchase_date, $branch_id, $purchase_order_id, $ref_no;
    public $items = [];
    public $supplier_sale_order_no;  // Keep the supplier_sale_order_no field
    public $supplierSaleOrderNos = [];
    public $purchaseOrders, $suppliers, $branches, $products, $godowns;

    public function mount()
    {
        // Initialize properties
        $this->suppliers = CustomerSupplier::where('customer_supplier', 'onlySupplier')->get();
        $this->branches = Branch::all();
        $this->products = Product::all();
        $this->godowns = [];  // Initially empty godowns, will be populated later
        $this->purchaseOrders = []; // Initially no purchase orders
        $this->purchase_date = now()->format('Y-m-d\TH:i');
        // Initialize items with a default item
        $this->items[] = $this->initializeItem();
    }
    public function selectProduct($index, $productId)
    {
        $product = Product::find($productId);

        if ($product) {
            // Set the product ID and product name
            $this->items[$index]['product_id'] = $product->id;
            $this->items[$index]['product_name'] = $product->product_name;
            
            // Set the price of the selected product
            $this->items[$index]['price'] = $product->price;
        }
    }
    private function initializeItem()
    {
        return [
            'product_id' => null,
            'quantity' => 0,
            'price' => 0,
            'discount' => 0,
            'godown_id' => null,
            'sub_total' => 0,
        ];
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

    // Update purchase orders based on selected supplier
    public function updatedSupplierId($supplierId)
    {
        $this->purchaseOrders = PurchaseOrder::where('supplier_id', $supplierId)->get();
        $this->supplierSaleOrderNos = PurchaseOrder::where('supplier_id', $supplierId)
                                                   ->pluck('supplier_sale_order_no', 'id')
                                                   ->toArray();
        
        // Reset order number fields
        $this->purchase_order_id = null;
        $this->supplier_sale_order_no = null;
        $this->items = [];
    }

    // Update godowns based on the selected branch
    public function updatedBranchId($branchId)
    {
        // Fetch the godowns related to the selected branch
        $this->godowns = Godown::where('branch_id', $branchId)->get();
        
        if($this->godowns->isNotEmpty()){
            $firstGodownId = $this->godowns->first()->id;
            foreach ($this->items as &$item) {
                $item['godown_id'] = $firstGodownId;
            }
        }else{
            foreach ($this->items as &$item) {
                $item['godown_id'] = null;
            }
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
    // public function updatedItems($value , $index){
    //     if (isset($this->items[$index]) && empty($value) || $value <= 0) {
    //         unset($this->items[$index]);
    //         $this->items = array_values($this->items);
    //     }
    // }
    // Save the purchase and its items
    public function save()
{
    $this->validate([
        'supplier_id' => 'required|exists:customer_suppliers,id',
        'purchase_date' => 'required|date',
        'branch_id' => 'required|exists:branches,id',
        'purchase_order_id' => 'nullable|exists:purchase_orders,id', // Allow null for purchase_order_id
        'supplier_sale_order_no' => 'nullable', // Allow null for supplier_sale_order_no
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|numeric|min:0',
        'items.*.price' => 'required|numeric|min:0',
        'items.*.discount' => 'nullable|numeric|min:0|max:100',
        'items.*.godown_id' => 'required|exists:godowns,id',
    ]);

    // Ensure that at least one of the order fields (purchase_order_id or supplier_sale_order_no) is filled
    if (!$this->supplier_sale_order_no && !$this->purchase_order_id) {
        toastr()->closeButton(true)->error('Either Supplier Sale Order Number or Purchase Order ID must be filled.');
        return;
    }
    $this->items = array_filter($this->items,function($item){
        return isset($item['quantity']) && $item['quantity'] > 0;
    });
    if(empty($this->items)){
        toastr()->error('no valid items to save');
        return;
    }
    // Create the purchase record
    $purchase = Purchase::create([
        'supplier_id' => $this->supplier_id,
        'purchase_date' => $this->purchase_date,
        'branch_id' => $this->branch_id,
        'purchase_order_id' => $this->purchase_order_id ?? null,  // Only set purchase_order_id if it's available
        'supplier_sale_order_no' => $this->supplier_sale_order_no ?? null,  // Only set supplier_sale_order_no if it's available
        'ref_no' => $this->ref_no,
        'user_id' => auth()->id(),
    ]);

    // $validItems = [];
    // Create or update purchase items
    foreach ($this->items as $key => $item) {
        if(empty($item['quantity']) || $item['quantity'] <= 0){
            continue;
        }
        // Add user_id to item data
        $item['user_id'] = Auth::id();

        // Create purchase item
        $purchaseItem = $purchase->items()->create($item);

        // Update the product's stock in the specific godown
        $product = Product::find($item['product_id']);
        if ($product) {
            // Update the stock based on godown_id
            $product->stock()->where('godown_id', $item['godown_id'])->increment('opening_stock', $item['quantity']);
        }
        $purchaseOrderItem = PurchaseOrderItem::where('purchase_order_id',$purchase->purchase_order_id)
                            ->where('product_id',$item['product_id'])
                            ->first();
        if($purchaseOrderItem){
            // dd(purchaseOrderItem);
            $purchaseOrderItem->quantity = $purchaseOrderItem->quantity - $item['quantity'];
            $purchaseOrderItem->save();
        }
        // $validItems[]    = $items;
    }
    // $this->items = $validItems;
    toastr()->closeButton(true)->success('Purchase saved successfully!');
    return redirect()->route('purchase.index'); // Ensure the route is correct
}




    // Render the component view
    public function render()
    {
        return view('livewire.inv-management.purchase-form');
    }
}
