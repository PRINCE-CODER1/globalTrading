<?php

namespace App\Livewire\InvManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CustomerSupplier;
use App\Models\User;
use App\Models\Segment;
use App\Models\Godown;
use App\Models\LeadSource;
use App\Models\Branch;
use App\Models\Product;
use App\Models\SaleOrder;
use App\Models\MasterNumbering;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleOrderForm extends Component
{
    use WithPagination;

    public $saleOrderNo;
    public $date;
    public $customer_id;
    public $agent_id;
    public $segment_id;
    public $lead_source_id;
    public $order_branch_id;
    public $delivery_branch_id;

    public $products = [];
    public $netAmount = 0;

    public $customers;
    public $agents;
    public $segments;
    public $leadSources;
    public $branches;
    public $godowns = [];
    public $productsList = [];

    protected $rules = [
        'date' => 'required|date',
        'customer_id' => 'required|exists:customer_suppliers,id',
        'agent_id' => 'required|exists:users,id',
        'segment_id' => 'required|exists:segments,id',
        'lead_source_id' => 'required|exists:lead_sources,id',
        'order_branch_id' => 'required|exists:branches,id',
        'delivery_branch_id' => 'required|exists:godowns,id',
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.expected_date' => 'required|date',
        'products.*.quantity' => 'required|numeric|min:1',
        'products.*.price' => 'required|numeric|min:0',
        'products.*.discount' => 'nullable|numeric|min:0|max:100',
    ];

    public function mount()
    {
        $this->customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get();
        $this->agents = User::where('role', 'agent')->get();
        $this->segments = Segment::all();
        $this->leadSources = LeadSource::all();
        $this->branches = Branch::all();
        $this->productsList = Product::all(); // Initialize with all products
        $this->products[] = $this->createEmptyProduct();
        $this->generateSaleOrderNo();
    }

    public function render()
    {
        return view('livewire.inv-management.sale-order-form');
    }

    public function updatedOrderBranchId($branchId)
    {
        $this->godowns = Godown::where('branch_id', $branchId)->get();
        $this->productsList = Product::where('branch_id', $branchId)->get();
        $this->reset('delivery_branch_id');
        $this->reset('products');
    }

    public function updatedDeliveryBranchId($godownId)
    {
        $godown = Godown::find($godownId);
        if ($godown) {
            $this->productsList = $godown->products;
            $this->calculateNetAmount();
        }
    }

    public function addProduct()
    {
        $this->products[] = $this->createEmptyProduct();
        $this->calculateNetAmount();
    }

    public function removeProduct($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products);
        $this->calculateNetAmount();
    }

    public function updatedProducts()
    {
        $this->calculateNetAmount();
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            // Generate the new Sale Order Number
            $this->generateSaleOrderNo();

            // Create the new Sale Order
            $saleOrder = SaleOrder::create([
                'sale_order_no' => $this->saleOrderNo,
                'date' => $this->date,
                'customer_id' => $this->customer_id,
                'agent_id' => $this->agent_id,
                'segment_id' => $this->segment_id,
                'lead_source_id' => $this->lead_source_id,
                'order_branch_id' => $this->order_branch_id,
                'delivery_branch_id' => $this->delivery_branch_id,
                'net_amount' => $this->netAmount,
                'user_id' => auth()->id(),
            ]);

            // Attach products to the Sale Order
            foreach ($this->products as $product) {
                $saleOrder->products()->updateOrCreate(
                    ['product_id' => $product['product_id']],
                    [
                        'expected_date' => $product['expected_date'],
                        'quantity' => $product['quantity'],
                        'price' => $product['price'],
                        'discount' => $product['discount'],
                        'subtotal' => $product['subtotal'],
                        'user_id' => auth()->id(),
                    ]
                );
            }

            // Ensure transaction consistency
            DB::commit();
        });

        session()->flash('message', 'Sale Order created successfully.');

        return redirect()->route('sale_orders.index');
    }

    protected function createEmptyProduct()
    {
        return [
            'product_id' => '',
            'expected_date' => '',
            'quantity' => 1,
            'price' => 0,
            'discount' => 0,
            'subtotal' => 0,
        ];
    }

    public function calculateNetAmount()
    {
        $this->netAmount = 0;

        foreach ($this->products as &$product) { // Use reference to modify the array
            $quantity = is_numeric($product['quantity']) ? (float) $product['quantity'] : 0;
            $price = is_numeric($product['price']) ? (float) $product['price'] : 0;
            $discount = is_numeric($product['discount']) ? (float) $product['discount'] : 0;

            // Calculate subtotal
            $subtotal = ($quantity * $price) - ($quantity * $price * $discount / 100);
            $product['subtotal'] = $subtotal;

            // Add to net amount
            $this->netAmount += $subtotal;
        }
    }

    public function generateSaleOrderNo()
    {
        // Fetch the latest MasterNumbering record
        $masterNumbering = MasterNumbering::first();
        if (!$masterNumbering) {
            session()->flash('error', 'Master numbering not found.');
            return;
        }

        // Extract the format from MasterNumbering
        $format = $masterNumbering->sale_order_format;

        // Extract prefix, numeric part, and suffix from the format
        preg_match('/^(.+)\/(\d{3})\/(.+)$/', $format, $matches);
        if (!$matches) {
            session()->flash('error', 'Invalid format in MasterNumbering.');
            return;
        }

        $prefix = $matches[1];
        $currentNumber = intval($matches[2]);
        $suffix = $matches[3];

        // Fetch the latest sale order number from the database
        $lastSaleOrder = SaleOrder::orderBy('created_at', 'desc')->first();
        $newNumber = $currentNumber; // Default to current number if no previous order

        // Extract the numeric part from the latest sale order number if it exists
        if ($lastSaleOrder) {
            preg_match('/\/(\d{3})\//', $lastSaleOrder->sale_order_no, $lastMatches);
            if ($lastMatches) {
                $newNumber = intval($lastMatches[1]) + 1; // Increment the number
            }
        }

        // Ensure the number is zero-padded
        $newNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Generate new sale order number
        $this->saleOrderNo = sprintf("%s/%s/%s", $prefix, $newNumber, $suffix);

        // Update MasterNumbering with the new number
        $masterNumbering->update([
            'sale_order_format' => sprintf("%s/%s/%s", $prefix, $newNumber, $suffix),
        ]);
    }
}
