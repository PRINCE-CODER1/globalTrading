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
        
        // Initialize items array with a default item
        $this->items[] = $this->initializeItem();

        // Generate the Purchase Order No
        $this->generatePurchaseOrderNo();
    }

    private function initializeItem()
    {
        return [
            'product_id' => null,
            'quantity' => null,
            'price' => null,
            'discount' => null,
            'godown_id' => null,
            'sub_total' => 0,
        ];
    }

    public function generatePurchaseOrderNo()
    {
        $masterNumbering = MasterNumbering::first();
        if (!$masterNumbering) {
            return redirect()->back()->withErrors(['error' => 'Master numbering not found.']);
        }

        $format = $masterNumbering->purchase_format;
        $latestOrder = Purchase::latest('created_at')->first();
        $currentNumber = 0;

        if ($latestOrder) {
            preg_match('/(\d{3})/', $latestOrder->purchase_no, $matches);
            $currentNumber = isset($matches[0]) ? intval($matches[0]) : 0;
        }

        $newNumber = $currentNumber > 0 ? str_pad($currentNumber + 1, 3, '0', STR_PAD_LEFT) : '001';
        $this->purchaseOrderNo = preg_replace('/\d{3}/', $newNumber, $format);
    }

    public function updatedSupplierId($supplierId)
    {
        $this->purchaseOrders = PurchaseOrder::where('supplier_id', $supplierId)->get();
        if ($this->purchase_order_id && !$this->purchaseOrders->contains('id', $this->purchase_order_id)) {
            $this->purchase_order_id = null;
        }
    }

    public function updated($attribute)
    {
        if (str_starts_with($attribute, 'items.')) {
            $index = explode('.', $attribute)[1];
            $this->updateSubTotal($index);
        }
    }

    public function updateSubTotal($index)
    {
        $item = &$this->items[$index];
        $quantity = floatval($item['quantity'] ?? 0);
        $price = floatval($item['price'] ?? 0);
        $discountPercentage = floatval($item['discount'] ?? 0);

        $subTotalBeforeDiscount = $quantity * $price;
        $discountAmount = ($discountPercentage / 100) * $subTotalBeforeDiscount;
        $item['sub_total'] = $subTotalBeforeDiscount - $discountAmount;
    }

    public function addItem()
    {
        $this->items[] = $this->initializeItem();
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Re-index the array
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

            // Update the product's stock in the specific godown
            $product = Product::find($item['product_id']);
            if ($product) {
                // Update the stock based on godown_id
                $product->stock()->where('godown_id', $item['godown_id'])->increment('opening_stock', $item['quantity']);
            }
        }

        // Update MasterNumbering with new number
        $this->updateMasterNumbering();

        toastr()->closeButton(true)->success('Created successfully.');
        return redirect()->route('purchase.index');
    }

    private function updateMasterNumbering()
    {
        $masterNumbering = MasterNumbering::first();
        if ($masterNumbering) {
            $currentFormat = $masterNumbering->purchase_format;

            preg_match('/^(.*?)\/(\d+)\/(.*?)$/', $currentFormat, $matches);
            $prefix = $matches[1];
            $number = isset($matches[2]) ? (int)$matches[2] : 0;
            $suffix = $matches[3] ?? '';

            $newNumber = $number + 1;
            $newFormat = sprintf("%s/%03d/%s", $prefix, $newNumber, $suffix);
            $masterNumbering->update(['purchase_format' => $newFormat]);
        }
    }

    public function render()
    {
        return view('livewire.inv-management.purchase-form');
    }
}
