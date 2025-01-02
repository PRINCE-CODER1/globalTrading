<?php

namespace App\Livewire\Invmanagement;

use Livewire\Component;
use App\Models\PurchaseOrder;
use App\Models\CustomerSupplier;
use App\Models\User;
use App\Models\Segment;
use App\Models\Product;
use App\Models\MasterNumbering;
use Illuminate\Support\Facades\Auth;

class CreatePurchaseOrder extends Component
{
    public $purchase_order_no;
    public $GTE_PO_NO;
    public $date;
    public $supplier_id;
    public $supplier_sale_order_no;
    public $agent_id;
    public $segment_id;
    public $sub_segment_id;
    public $sub_segments = [];
    public $customer_id;
    public $customer_sale_order_no;
    public $customer_sale_order_date;
    public $user_id;
    public $subtotal = 0;

    public $items = [];

    public $suppliers;
    public $customers;
    public $agents;
    public $segments;
    public $products;

    public $productSearch = '';

    public function mount()
    {
        $this->loadInitialData();
        $this->addItem(); // Initialize with one item row
        $this->generatePurchaseOrderNo(); // Generate purchase order number
        $this->date = now()->format('Y-m-d\TH:i'); // Initialize date
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

            // Optionally, calculate the amount based on the price and quantity
            $this->calculateAmount($index);
        }
    }

    /**
     * Generate a unique purchase order number based on the master numbering format.
     */
    public function generatePurchaseOrderNo()
    {
        // Fetch the latest MasterNumbering record
        $masterNumbering = MasterNumbering::first();
        if (!$masterNumbering) {
            session()->flash('error', 'Master numbering not found.');
            return;
        }

        // Extract format from MasterNumbering
        $format = $masterNumbering->purchase_order_format;

        // Extract prefix, numeric part, and suffix
        preg_match('/^(.+)\/(\d{3})\/(.+)$/', $format, $matches);
        if (!$matches) {
            session()->flash('error', 'Invalid format in MasterNumbering.');
            return;
        }

        $prefix = $matches[1];
        $currentNumber = intval($matches[2]);
        $suffix = $matches[3];

        // Fetch the latest purchase order number
        $lastPurchaseOrder = PurchaseOrder::orderBy('created_at', 'desc')->first();
        $newNumber = $currentNumber;

        // Increment the number if there’s a previous order
        if ($lastPurchaseOrder) {
            preg_match('/\/(\d{3})\//', $lastPurchaseOrder->purchase_order_no, $lastMatches);
            if ($lastMatches) {
                $newNumber = intval($lastMatches[1]) + 1;
            }
        }

        // Zero-pad the new number
        $newNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Generate the new purchase order number
        $this->purchase_order_no = sprintf("%s/%s/%s", $prefix, $newNumber, $suffix);

        // Update the MasterNumbering record
        $masterNumbering->update([
            'purchase_order_format' => sprintf("%s/%s/%s", $prefix, $newNumber, $suffix),
        ]);
    }


    /**
     * Load initial data for dropdowns and related fields.
     */
    private function loadInitialData()
    {
        $this->suppliers = CustomerSupplier::where('customer_supplier', 'onlySupplier')->get();
        $this->customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get();
        $this->agents = User::where('role', 'Agent')->get();
        $this->segments = Segment::whereNull('parent_id')->get();
        $this->sub_segments = [];
        $this->loadProducts();
    }

    /**
     * Update sub-segments when a segment is selected.
     */
    public function updatedSegmentId($value)
    {
        $this->sub_segments = Segment::where('parent_id', $value)->get();
        $this->sub_segment_id = null; // Reset sub-segment selection
    }

    /**
     * Search for products based on user input.
     */
    public function updatedProductSearch()
    {
        $this->loadProducts();
    }

    /**
     * Load products based on the search term.
     */
    public function loadProducts()
    {
        $this->products = Product::query()
            ->when($this->productSearch, function ($query) {
                $query->where('product_name', 'like', '%' . $this->productSearch . '%');
            })
            ->get();
    }

    /**
     * Add an item row for the purchase order.
     */
    public function addItem()
    {
        $this->items[] = [
            'product_id' => '',
            'quantity' => 1,
            'price' => 0,
            'discount' => 0,
            'amount' => 0,
        ];
    }

    /**
     * Remove an item row from the purchase order.
     */
    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Reindex the array
        $this->updateSubtotal();
    }

    /**
     * Calculate the amount for an item row.
     */
    public function calculateAmount($index)
    {
        $item = &$this->items[$index];
        $price = (float) $item['price'];
        $quantity = (int) $item['quantity'];
        $discount = (float) $item['discount'];

        $item['amount'] = ($price * $quantity) - ($price * $quantity * $discount / 100);
        $this->updateSubtotal();
    }

    /**
     * Update the subtotal for the purchase order.
     */
    public function updateSubtotal()
    {
        $this->subtotal = array_sum(array_column($this->items, 'amount'));
    }

    /**
     * Save the purchase order and its items.
     */
    public function save()
    {
        $this->validate($this->getValidationRules());

        $purchaseOrder = PurchaseOrder::create($this->getPurchaseOrderData());

        foreach ($this->items as $item) {
            $purchaseOrder->items()->create($item);
        }

        toastr()->closeButton(true)->success('Purchase Order created successfully.');
        return redirect()->route('purchase_orders.index');
    }

    /**
     * Validation rules for the purchase order.
     */
    private function getValidationRules()
    {
        return [
            'purchase_order_no' => 'required|string|unique:purchase_orders,purchase_order_no',
            'GTE_PO_NO' => 'required|string|unique:purchase_orders,GTE_PO_NO',
            'date' => 'required|date',
            'supplier_id' => 'required|exists:customer_suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0|max:100',
        ];
    }

    /**
     * Prepare data for creating a purchase order.
     */
    private function getPurchaseOrderData()
    {
        return [
            'purchase_order_no' => $this->purchase_order_no,
            'GTE_PO_NO' => $this->GTE_PO_NO,
            'date' => $this->date,
            'supplier_id' => $this->supplier_id,
            'supplier_sale_order_no' => $this->supplier_sale_order_no,
            'user_id' => Auth::id(),
            'subtotal' => $this->subtotal,
        ];
    }

    public function render()
    {
        return view('livewire.inv-management.create-purchase-order');
    }
}
