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

class PurchaseEdit extends Component
{
    use WithFileUploads;

    public $purchaseId;
    public $supplier_id;
    public $purchase_date;
    public $branch_id;
    public $purchase_order_id;
    public $ref_no;
    public $destination;
    public $received_through;
    public $gr_no;
    public $gr_date;
    public $weight;
    public $no_of_boxes;
    public $vehicle_no;
    public $items = [];
    public $purchaseOrderNo;

    public $suppliers;
    public $branches;
    public $products;
    public $godowns;
    public $purchaseOrders;

    public function mount($purchaseId)
    {
        $this->purchaseId = $purchaseId;

        // Initialize dropdown options
        $this->suppliers = CustomerSupplier::where('customer_supplier', 'onlySupplier')->get();
        $this->branches = Branch::all();
        $this->products = Product::all();
        $this->godowns = Godown::all();
        $this->purchaseOrders = [];

        // Fetch the purchase and its items
        $purchase = Purchase::with('items')->find($this->purchaseId);

        if ($purchase) {
            $this->supplier_id = $purchase->supplier_id;
            $this->purchase_date = $purchase->purchase_date;
            $this->branch_id = $purchase->branch_id;
            $this->purchase_order_id = $purchase->purchase_order_id;
            $this->ref_no = $purchase->ref_no;
            $this->destination = $purchase->destination;
            $this->received_through = $purchase->received_through;
            $this->gr_no = $purchase->gr_no;
            $this->gr_date = $purchase->gr_date;
            $this->weight = $purchase->weight;
            $this->no_of_boxes = $purchase->no_of_boxes;
            $this->vehicle_no = $purchase->vehicle_no;
            $this->items = $purchase->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'discount' => $item->discount,
                    'godown_id' => $item->godown_id,
                    'sub_total' => $item->sub_total,
                ];
            })->toArray();

            // Fetch purchase orders for the selected supplier
            $this->purchaseOrders = PurchaseOrder::where('supplier_id', $this->supplier_id)->get();

            // Set the purchase order number
            $this->purchaseOrderNo = $purchase->purchase_no;
        } else {
            return redirect()->route('purchase.index')->withErrors(['error' => 'Purchase not found.']);
        }
    }

    public function updatedSupplierId($supplierId)
    {
        // Fetch purchase orders for the selected supplier
        $this->purchaseOrders = PurchaseOrder::where('supplier_id', $supplierId)->get();
        // Reset the purchase order if it's not valid anymore
        if ($this->purchase_order_id && !$this->purchaseOrders->contains('id', $this->purchase_order_id)) {
            $this->purchase_order_id = null;
        }
    }

    public function updated($attribute)
    {
        if (str_starts_with($attribute, 'items.')) {
            // Extract the index from the attribute name
            $index = explode('.', $attribute)[1];
            // Update sub-total for the affected item
            $this->updateSubTotal($index);
        }
    }

    public function updateSubTotal($index)
    {
        // Ensure the index is an integer and valid
        $index = intval($index);

        // Check if the item exists at the given index
        if (isset($this->items[$index])) {
            $item = &$this->items[$index];

            // Ensure all values are treated as floats for accurate calculations
            $quantity = floatval($item['quantity'] ?? 0);
            $price = floatval($item['price'] ?? 0);
            $discountPercentage = floatval($item['discount'] ?? 0);

            // Calculate the subtotal before applying the discount
            $subTotalBeforeDiscount = $quantity * $price;

            // Calculate the discount amount based on percentage
            $discountAmount = ($discountPercentage / 100) * $subTotalBeforeDiscount;

            // Calculate the final subtotal after applying the discount
            $item['sub_total'] = $subTotalBeforeDiscount - $discountAmount;
        }
    }

    public function addItem()
    {
        $this->items[] = [
            'id' => null,
            'product_id' => null,
            'quantity' => null,
            'price' => null,
            'discount' => null,
            'godown_id' => null,
            'sub_total' => 0, 
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function update()
    {
        // Validate the inputs
        $this->validate([
            'supplier_id' => 'required|exists:customer_suppliers,id',
            'purchase_date' => 'required|date',
            'branch_id' => 'required|exists:branches,id',
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'ref_no' => 'nullable|string',
            'destination' => 'nullable|string',
            'received_through' => 'nullable|string',
            'gr_no' => 'nullable|string',
            'gr_date' => 'nullable|date',
            'weight' => 'nullable|numeric',
            'no_of_boxes' => 'nullable|integer',
            'vehicle_no' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.godown_id' => 'required|exists:godowns,id',
            'items.*.sub_total' => 'required|numeric|min:0', 
        ]);

        // Find the purchase record
        $purchase = Purchase::findOrFail($this->purchaseId);

        // Update the purchase record
        $purchase->update([
            'supplier_id' => $this->supplier_id,
            'purchase_date' => $this->purchase_date,
            'branch_id' => $this->branch_id,
            'purchase_order_id' => $this->purchase_order_id,
            'ref_no' => $this->ref_no,
            'destination' => $this->destination,
            'received_through' => $this->received_through,
            'gr_no' => $this->gr_no,
            'gr_date' => $this->gr_date,
            'weight' => $this->weight,
            'no_of_boxes' => $this->no_of_boxes,
            'vehicle_no' => $this->vehicle_no,
            'user_id' => Auth::id(),
        ]);

        // Update purchase items
        foreach ($this->items as $item) {
            // Ensure sub_total is not null
            $item['sub_total'] = isset($item['sub_total']) ? $item['sub_total'] : 0;

            // Find or create purchase item
            $purchaseItem = $purchase->items()->updateOrCreate(
                ['id' => $item['id']], // Ensure 'id' exists or handle creation appropriately
                array_merge($item, ['user_id' => Auth::id()])
            );
        }

        toastr()->closeButton(true)->success('Updated successfully.');
        return redirect()->route('purchase.index');
    }

    public function render()
    {
        return view('livewire.inv-management.purchase-edit');
    }
}
