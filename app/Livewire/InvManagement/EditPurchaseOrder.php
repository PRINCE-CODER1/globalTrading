<?php

namespace App\Livewire\Invmanagement;

use Livewire\Component;
use App\Models\PurchaseOrder;
use App\Models\CustomerSupplier;
use App\Models\Product;
use App\Models\MasterNumbering;

class EditPurchaseOrder extends Component
{
    public $purchase_order_no;
    public $date;
    public $supplier_id;
    public $supplier_sale_order_no;
    public $customer_sale_order_no;
    public $customer_sale_order_date;
    public $subtotal = 0;
    public $items = [];

    public $suppliers;
    public $productSearch = '';
    public $products = [];
    public $currentIndex;

    public $GTE_PO_NO;  // Declare the GTE_PO_NO property

    public function mount($purchaseOrder = null)
    {
        $this->suppliers = CustomerSupplier::where('customer_supplier', 'onlySupplier')->get();
        $this->loadProducts();
        $this->addItem();

        if ($purchaseOrder) {
            $this->populateData($purchaseOrder);
        } else {
            $this->generatePurchaseOrderNo();
        }
    }

    public function setCurrentIndex($index)
    {
        $this->currentIndex = $index;
    }

    public function selectProduct($index, $productId)
    {
        $product = Product::find($productId);
        $this->items[$index]['product_name'] = $product->product_name;
        $this->items[$index]['product_id'] = $product->id;
    }

    public function populateData(PurchaseOrder $purchaseOrder)
    {
        $this->purchase_order_no = $purchaseOrder->purchase_order_no;
        $this->GTE_PO_NO = $purchaseOrder->GTE_PO_NO;
        $this->date = $purchaseOrder->date;
        $this->supplier_id = $purchaseOrder->supplier_id;
        $this->supplier_sale_order_no = $purchaseOrder->supplier_sale_order_no;
        $this->customer_sale_order_no = $purchaseOrder->customer_sale_order_no;
        $this->customer_sale_order_date = $purchaseOrder->customer_sale_order_date;
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

    public function loadProducts()
    {
        $this->products = Product::query()
            ->when($this->productSearch, function ($query) {
                $query->where('product_name', 'like', '%' . $this->productSearch . '%');
            })
            ->get();
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
        // Updated validation with correct GTE_PO_NO validation
        $this->validate([
            'purchase_order_no' => 'required|string|unique:purchase_orders,purchase_order_no,' . ($this->purchase_order_no ?? 'NULL') . ',purchase_order_no',
            'GTE_PO_NO' => 'required|string',
            'date' => 'required|date',
            'supplier_id' => 'required|exists:customer_suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0|max:100',
        ]);

        $purchaseOrder = PurchaseOrder::updateOrCreate(
            ['purchase_order_no' => $this->purchase_order_no],
            [
                'GTE_PO_NO' => $this->GTE_PO_NO,  // Ensure GTE_PO_NO is passed
                'date' => $this->date,
                'supplier_id' => $this->supplier_id,
                'supplier_sale_order_no' => $this->supplier_sale_order_no,
                'customer_sale_order_no' => $this->customer_sale_order_no,
                'customer_sale_order_date' => $this->customer_sale_order_date,
                'user_id' => auth()->id(),
                'subtotal' => $this->subtotal,
            ]
        );

        if (!$purchaseOrder) {
            session()->flash('error', 'Failed to save the purchase order.');
            return;
        }

        // Delete existing items and add new ones
        $purchaseOrder->items()->delete();
        foreach ($this->items as $item) {
            $existingItem = $purchaseOrder->items()->where('product_id', $item['product_id'])->first();
            if ($existingItem) {
                // Update existing item
                $existingItem->update($item);
            } else {
                // Create new item
                $purchaseOrder->items()->create($item);
            }
        }

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
