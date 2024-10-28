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
use App\Models\Stock; // Assuming Stock model is defined
use Illuminate\Support\Facades\DB;

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
        $this->productsList = Product::all(); 
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

        // Fetch products based on stock availability in the selected branch
        $this->productsList = Product::whereHas('stock', function ($query) use ($branchId) {
            $query->where('branch_id', $branchId);
        })->get();

        // Reset delivery branch and products for fresh data
        $this->reset('delivery_branch_id');
        $this->reset('products');
    }

    public function updatedDeliveryBranchId($godownId)
    {
        $this->productsList = Product::whereHas('stock', function ($query) use ($godownId) {
            $query->where('godown_id', $godownId);
        })->get();

        // Recalculate net amount based on the selected godown
        $this->calculateNetAmount();
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
            // Generate new sale order number
            $this->generateSaleOrderNo();

            // Create new sale order
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

            // Attach products to sale order
            foreach ($this->products as $product) {
                $saleOrder->products()->updateOrCreate(
                    ['product_id' => $product['product_id']],
                    [
                        'expected_date' => $product['expected_date'],
                        'quantity' => $product['quantity'],
                        'price' => $product['price'],
                        'discount' => $product['discount'],
                        'sub_total' => $product['subtotal'], // Use subtotal key
                        'user_id' => auth()->id(),
                    ]
                );
            }
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

        foreach ($this->products as &$product) {
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
        // Fetch latest MasterNumbering record
        $masterNumbering = MasterNumbering::first();
        if (!$masterNumbering) {
            session()->flash('error', 'Master numbering not found.');
            return;
        }

        // Extract format from MasterNumbering
        $format = $masterNumbering->sale_order_format;

        // Extract prefix, numeric part, and suffix
        preg_match('/^(.+)\/(\d{3})\/(.+)$/', $format, $matches);
        if (!$matches) {
            session()->flash('error', 'Invalid format in MasterNumbering.');
            return;
        }

        $prefix = $matches[1];
        $currentNumber = intval($matches[2]);
        $suffix = $matches[3];

        // Fetch latest sale order number
        $lastSaleOrder = SaleOrder::orderBy('created_at', 'desc')->first();
        $newNumber = $currentNumber;

        // Increment number if there’s a previous order
        if ($lastSaleOrder) {
            preg_match('/\/(\d{3})\//', $lastSaleOrder->sale_order_no, $lastMatches);
            if ($lastMatches) {
                $newNumber = intval($lastMatches[1]) + 1;
            }
        }

        // Zero-pad new number
        $newNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Generate new sale order number
        $this->saleOrderNo = sprintf("%s/%s/%s", $prefix, $newNumber, $suffix);

        // Update MasterNumbering
        $masterNumbering->update([
            'sale_order_format' => sprintf("%s/%s/%s", $prefix, $newNumber, $suffix),
        ]);
    }
}
