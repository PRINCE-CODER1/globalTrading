<?php 

namespace App\Livewire\InvManagement;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerSupplier;
use App\Models\Sale;
use App\Models\Branch;
use App\Models\Godown;
use App\Models\Product;
use App\Models\SaleOrder;
use App\Models\MasterNumbering;

class SaleForm extends Component
{
    public $customer_id;
    public $sale_date;
    public $branch_id;
    public $sale_order_id;
    public $ref_no;
    public $destination;
    public $dispatch_through;
    public $gr_no;
    public $gr_date;
    public $select_date;
    public $weight;
    public $no_of_boxes;
    public $vehicle_no;
    public $items = [];
    public $saleOrderNo;

    public $customers;
    public $branches;
    public $products;
    public $godowns;
    public $saleOrders;

    public function mount()
    {
        $this->customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get();
        $this->branches = Branch::all();
        $this->products = []; 
        $this->godowns = Godown::all();
        $this->saleOrders = [];
        $this->items[] = $this->createEmptyItem();

        // Initialize Sale Order Number
        $this->initializeSaleOrderNo();
    }

    public function updatedBranchId($branchId)
    {
        // Fetch products for the selected branch
        $this->products = Product::where('branch_id', $branchId)->get();
        
        // Reset the items to use the filtered products
        foreach ($this->items as &$item) {
            if ($item['product_id'] && !$this->products->contains('id', $item['product_id'])) {
                $item['product_id'] = null; // Reset product ID if it's no longer available
            }
        }
    }

    public function updatedCustomerId($customerId)
    {
        // Fetch sale orders for the selected customer
        $this->saleOrders = SaleOrder::where('customer_id', $customerId)->get();
        // Reset the sale order if it's not valid anymore
        if ($this->sale_order_id && !$this->saleOrders->contains('id', $this->sale_order_id)) {
            $this->sale_order_id = null;
        }
    }

    public function addItem()
    {
        $this->items[] = $this->createEmptyItem();
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotals();
    }

    protected function createEmptyItem()
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

    public function calculateTotals()
    {
        foreach ($this->items as &$item) {
            $quantity = $item['quantity'] ?? 0;
            $price = $item['price'] ?? 0;
            $discount = $item['discount'] ?? 0;

            $item['sub_total'] = ($quantity * $price) - ($quantity * $price * $discount / 100);
        }
    }

    public function initializeSaleOrderNo()
    {
        $masterNumbering = MasterNumbering::first();
        if ($masterNumbering) {
            $currentFormat = $masterNumbering->sale_format;

            // Extract the prefix, numeric part, and suffix
            preg_match('/^(.*?)\/(\d+)\/(.*?)$/', $currentFormat, $matches);
            $prefix = $matches[1] ?? 'SA';
            $number = isset($matches[2]) ? (int)$matches[2] : 0; // Start with 0
            $suffix = $matches[3] ?? 'GTE';

            // Ensure the number is zero-padded
            $newNumberFormatted = str_pad($number + 1, 3, '0', STR_PAD_LEFT);

            // Create the new format
            $this->saleOrderNo = sprintf("%s/%s/%s", $prefix, $newNumberFormatted, $suffix);
        }
    }

    public function save()
    {
        $this->validate([
            'customer_id' => 'required|exists:customer_suppliers,id',
            'sale_date' => 'required|date',
            'branch_id' => 'required|exists:branches,id',
            'sale_order_id' => 'required|exists:sale_orders,id',
            'ref_no' => 'nullable|string',
            'destination' => 'nullable|string',
            'dispatch_through' => 'nullable|string',
            'gr_no' => 'nullable|string',
            'gr_date' => 'nullable|date',
            'select_date' => 'nullable|date',
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

        // Create the sale record
        $sale = Sale::create([
            'sale_no' => $this->saleOrderNo,
            'customer_id' => $this->customer_id,
            'sale_date' => $this->sale_date,
            'branch_id' => $this->branch_id,
            'sale_order_id' => $this->sale_order_id,
            'ref_no' => $this->ref_no,
            'destination' => $this->destination,
            'dispatch_through' => $this->dispatch_through,
            'gr_no' => $this->gr_no,
            'gr_date' => $this->gr_date,
            'select_date' => $this->select_date,
            'weight' => $this->weight,
            'no_of_boxes' => $this->no_of_boxes,
            'vehicle_no' => $this->vehicle_no,
            'user_id' => Auth::id(),
        ]);

        // Create sale items
        foreach ($this->items as $item) {
            $item['user_id'] = Auth::id(); 
            $sale->items()->create($item);

            $product = Product::find($item['product_id']);
            if ($product) {
                if ($product->opening_stock < $item['quantity']) {
                    toastr()->error('Not enough stock for product: ' . $product->product_name);
                    return;
                }
                $product->decrement('opening_stock', $item['quantity']);
            }
        }

        // Update MasterNumbering with the new format
        $masterNumbering = MasterNumbering::first();
        if ($masterNumbering) {
            $currentFormat = $masterNumbering->sale_format;
            preg_match('/^(.*?)\/(\d+)\/(.*?)$/', $currentFormat, $matches);
            $prefix = $matches[1] ?? 'SA';
            $number = isset($matches[2]) ? (int)$matches[2] + 1 : 1; // Increment the number
            $suffix = $matches[3] ?? 'GTE';

            // Ensure the number is zero-padded
            $newNumberFormatted = str_pad($number, 3, '0', STR_PAD_LEFT);

            // Update MasterNumbering
            $masterNumbering->update([
                'sale_format' => sprintf("%s/%s/%s", $prefix, $newNumberFormatted, $suffix)
            ]);
        }

        toastr()->closeButton(true)->success('Created successfully.');
        return redirect()->route('sales.index');
    }

    public function render()
    {
        return view('livewire.inv-management.sale-form',['products' => $this->products,]);
    }
}
