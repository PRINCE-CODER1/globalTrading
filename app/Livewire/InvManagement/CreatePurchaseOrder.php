<?php

namespace App\Livewire\Invmanagement;

use Livewire\Component;
use App\Models\PurchaseOrder;
use App\Models\CustomerSupplier;
use App\Models\User;
use App\Models\Segment;
use App\Models\Branch;
use App\Models\Godown;
use App\Models\Product;
use App\Models\MasterNumbering;

class CreatePurchaseOrder extends Component
{
    public $purchase_order_no;
    public $date;
    public $supplier_id;
    public $supplier_sale_order_no;
    public $agent_id;
    public $segment_id;
    public $order_branch_id;
    public $delivery_branch_id;
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
    public $branches;
    public $godowns;
    public $products;

    public function mount()
    {
        $this->loadInitialData();
        $this->addItem();
        $this->generatePurchaseOrderNo();
    }

    private function loadInitialData()
    {
        $this->suppliers = CustomerSupplier::where('customer_supplier', 'onlySupplier')->get();
        $this->customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get();
        $this->agents = User::where('role', 'Agent')->get();
        $this->segments = Segment::all();
        $this->branches = Branch::all();
        $this->loadGodowns();
        $this->loadProducts();
    }

    public function generatePurchaseOrderNo()
    {
        $masterNumbering = MasterNumbering::first();

        if (!$masterNumbering) {
            return redirect()->back()->withErrors(['error' => 'Master numbering not found.']);
        }

        $latestOrder = PurchaseOrder::latest('created_at')->first();
        $currentNumber = 0;

        if ($latestOrder) {
            preg_match('/(\d{3})/', $latestOrder->purchase_order_no, $matches);
            $currentNumber = isset($matches[0]) ? intval($matches[0]) : 0;
        }

        $newNumber = str_pad($currentNumber + 1, 3, '0', STR_PAD_LEFT);
        $this->purchase_order_no = preg_replace('/(\d{3})/', $newNumber, $masterNumbering->purchase_order_format);
    }

    public function updatedOrderBranchId($value)
    {
        $this->loadGodowns();
        $this->delivery_branch_id = null; // Reset delivery branch
        $this->loadProducts();
    }

    public function updatedDeliveryBranchId()
    {
        $this->loadProducts();
    }

    public function loadGodowns()
    {
        $this->godowns = $this->order_branch_id ? Godown::where('branch_id', $this->order_branch_id)->get() : [];
    }

    public function loadProducts()
    {
        if ($this->delivery_branch_id) {
            // Get products associated with the godown
            $this->products = Product::whereHas('stock', function ($query) {
                $query->where('godown_id', $this->delivery_branch_id);
            })->get();
        } else {
            $this->products = [];
        }
    }

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

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); 
        $this->updateSubtotal();
    }

    public function calculateAmount($index)
    {
        $item = &$this->items[$index];
        $price = (float) $item['price'];
        $quantity = (int) $item['quantity'];
        $discount = (float) $item['discount'];

        $item['amount'] = ($price * $quantity) - ($price * $quantity * $discount / 100);
        $this->updateSubtotal();
    }

    public function updateSubtotal()
    {
        $this->subtotal = array_sum(array_column($this->items, 'amount'));
    }

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

    private function getValidationRules()
    {
        return [
            'purchase_order_no' => 'required|string|unique:purchase_orders,purchase_order_no',
            'date' => 'required|date',
            'supplier_id' => 'required|exists:customer_suppliers,id',
            'agent_id' => 'required|exists:users,id',
            'segment_id' => 'required|exists:segments,id',
            'order_branch_id' => 'required|exists:branches,id',
            'delivery_branch_id' => 'required|exists:godowns,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0|max:100',
        ];
    }

    private function getPurchaseOrderData()
    {
        return [
            'purchase_order_no' => $this->purchase_order_no,
            'date' => $this->date,
            'supplier_id' => $this->supplier_id,
            'supplier_sale_order_no' => $this->supplier_sale_order_no,
            'agent_id' => $this->agent_id,
            'segment_id' => $this->segment_id,
            'order_branch_id' => $this->order_branch_id,
            'delivery_branch_id' => $this->delivery_branch_id,
            'customer_id' => $this->customer_id,
            'customer_sale_order_no' => $this->customer_sale_order_no,
            'customer_sale_order_date' => $this->customer_sale_order_date,
            'user_id' => auth()->id(),
            'subtotal' => $this->subtotal,
        ];
    }

    public function render()
    {
        return view('livewire.inv-management.create-purchase-order');
    }
}
