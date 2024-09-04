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
use App\Models\MasterNumbering;

class PurchaseForm extends Component
{
    use WithFileUploads;

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

    public function mount()
    {
        $this->suppliers = CustomerSupplier::where('customer_supplier', 'onlySupplier')->get();
        $this->branches = Branch::all();
        $this->products = Product::all();
        $this->godowns = Godown::all();
        $this->purchaseOrders = [];
        $this->items[] = [
            'product_id' => null,
            'quantity' => null,
            'price' => null,
            'discount' => null,
            'godown_id' => null,
            'sub_total' => 0, // Default to 0
        ];

        // Generate the Purchase Order No
        $this->generatePurchaseOrderNo();
    }

    public function generatePurchaseOrderNo()
    {
        // Fetch the latest MasterNumbering record
        $masterNumbering = MasterNumbering::first();
        if (!$masterNumbering) {
            return redirect()->back()->withErrors(['error' => 'Master numbering not found.']);
        }

        // Extract the format from MasterNumbering
        $format = $masterNumbering->purchase_format;

        // Fetch the latest purchase order number from the database
        $latestOrder = Purchase::latest('created_at')->first();
        $currentNumber = 0;

        // Extract the numeric part from the latest purchase order number if it exists
        if ($latestOrder) {
            preg_match('/(\d{3})/', $latestOrder->purchase_no, $matches);
            $currentNumber = isset($matches[0]) ? intval($matches[0]) : 0;
        }

        // If no previous orders exist, start from 001
        $newNumber = $currentNumber > 0 ? str_pad($currentNumber + 1, 3, '0', STR_PAD_LEFT) : '001';

        // Generate new format
        $this->purchaseOrderNo = preg_replace('/\d{3}/', $newNumber, $format);
    }


    public function updatedSupplierId($supplierId)
    {
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

    public function addItem()
    {
        $this->items[] = [
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

    public function save()
    {
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
            'items.*.sub_total' => 'nullable|numeric|min:0',
        ]);

        // Create the purchase record
        $purchase = Purchase::create([
            'purchase_no' => $this->purchaseOrderNo,
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

        // Create purchase items
        foreach ($this->items as $item) {
            $item['user_id'] = Auth::id();
            $purchase->items()->create($item);

            // Update the product's opening stock
            $product = Product::find($item['product_id']);
            if ($product) {
                $product->increment('opening_stock', $item['quantity']);
            }
        }

        // Update MasterNumbering with new number
        $masterNumbering = MasterNumbering::first();
        if ($masterNumbering) {
            $currentFormat = $masterNumbering->purchase_format;

            // Extract the prefix, numeric part, and suffix
            preg_match('/^(.*?)\/(\d+)\/(.*?)$/', $currentFormat, $matches);
            $prefix = $matches[1];
            $number = isset($matches[2]) ? (int)$matches[2] : 0;
            $suffix = $matches[3] ?? '';

            // Increment the number
            $newNumber = $number + 1;

            // Create the new format
            $newFormat = sprintf("%s/%03d/%s", $prefix, $newNumber, $suffix);
            $masterNumbering->update(['purchase_format' => $newFormat]);
        }

        toastr()->closeButton(true)->success('Created successfully.');
        return redirect()->route('purchase.index');
    }

    public function render()
    {
        return view('livewire.inv-management.purchase-form');
    }
}
