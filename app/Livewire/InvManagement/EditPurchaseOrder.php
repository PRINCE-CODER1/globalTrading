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

class EditPurchaseOrder extends Component
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
    public $subtotal = 0;

    public $items = [];

    public $suppliers;
    public $customers;
    public $agents;
    public $segments;
    public $branches;
    public $godowns;
    public $products;

    public function mount($purchaseOrder = null)
    {
        $this->suppliers = CustomerSupplier::where('customer_supplier', 'onlySupplier')->get();
        $this->customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get();
        $this->agents = User::all();
        $this->segments = Segment::all();
        $this->branches = Branch::all();
        $this->loadGodowns();
        $this->loadProducts();
        $this->addItem();

        if ($purchaseOrder) {
            $this->populateData($purchaseOrder);
        } else {
            $this->generatePurchaseOrderNo();
        }
    }

    public function populateData(PurchaseOrder $purchaseOrder)
    {
        $this->purchase_order_no = $purchaseOrder->purchase_order_no;
        $this->date = $purchaseOrder->date;
        $this->supplier_id = $purchaseOrder->supplier_id;
        $this->supplier_sale_order_no = $purchaseOrder->supplier_sale_order_no;
        $this->agent_id = $purchaseOrder->agent_id;
        $this->segment_id = $purchaseOrder->segment_id;
        $this->order_branch_id = $purchaseOrder->order_branch_id;
        $this->delivery_branch_id = $purchaseOrder->delivery_branch_id;
        $this->customer_id = $purchaseOrder->customer_id;
        $this->customer_sale_order_no = $purchaseOrder->customer_sale_order_no;
        $this->customer_sale_order_date = $purchaseOrder->customer_sale_order_date;
        $this->user_id = $purchaseOrder->user_id;
        $this->subtotal = $purchaseOrder->subtotal;
        $this->items = $purchaseOrder->items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'discount' => $item->discount,
                'amount' => $item->amount,
            ];
        })->toArray();
    }

    public function generatePurchaseOrderNo()
    {
        $masterNumbering = MasterNumbering::first();
        if (!$masterNumbering) {
            session()->flash('error', 'Master numbering not found.');
            return redirect()->back();
        }

        preg_match('/(\d+)/', $masterNumbering->purchase_order_format, $matches);
        $number = isset($matches[0]) ? intval($matches[0]) : 0;
        $number += 1;
        $this->purchase_order_no = sprintf("PE/%03d/WV", $number);
    }

    public function updatedOrderBranchId($value)
    {
        $this->loadGodowns();
        // Reset delivery branch and products when order branch changes
        $this->delivery_branch_id = null;
        $this->loadProducts();
    }

    public function updatedDeliveryBranchId()
    {
        $this->loadProducts();
    }

    public function loadGodowns()
    {
        if ($this->order_branch_id) {
            $this->godowns = Godown::where('branch_id', $this->order_branch_id)->get();
        } else {
            $this->godowns = [];
        }
    }

    public function loadProducts()
    {
        if ($this->delivery_branch_id) {
            $this->products = Product::where('godown_id', $this->delivery_branch_id)->get();
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
        $price = $item['price'];
        $quantity = $item['quantity'];
        $discount = $item['discount'];

        $amount = ($price * $quantity) - ($price * $quantity * $discount / 100);
        $item['amount'] = $amount;

        $this->updateSubtotal();
    }

    public function updateSubtotal()
    {
        $this->subtotal = array_sum(array_column($this->items, 'amount'));
    }

    public function update()
    {
        $this->validate([
            'purchase_order_no' => 'required|string|unique:purchase_orders,purchase_order_no,' . ($this->purchase_order_no ?? 'NULL') . ',purchase_order_no',
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
        ]);

        // Create or update the Purchase Order
        $purchaseOrder = PurchaseOrder::updateOrCreate(
            ['purchase_order_no' => $this->purchase_order_no],
            [
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
            ]
        );

        // Debugging output
        if (!$purchaseOrder) {
            session()->flash('error', 'Failed to save the purchase order.');
            return;
        }

        // Clear existing items and create new ones
        $purchaseOrder->items()->delete();

        foreach ($this->items as $item) {
            $purchaseOrder->items()->create($item);
        }

        // Update MasterNumbering with the new format
        $masterNumbering = MasterNumbering::first();
        if ($masterNumbering) {
            $number = (int)preg_replace('/\D/', '', $masterNumbering->purchase_order_format);
            $masterNumbering->update(['purchase_order_format' => sprintf("PE/%03d/WV", $number + 1)]);
        } else {
            session()->flash('error', 'Master numbering not found.');
            return;
        }
        
        toastr()->closeButton(true)->success('Purchase Order updated successfully.');
        return redirect()->route('purchase_orders.index');
    }


    public function render()
    {
        return view('livewire.inv-management.edit-purchase-order');
    }
}
