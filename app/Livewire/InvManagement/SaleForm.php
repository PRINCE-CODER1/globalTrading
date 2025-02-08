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
use App\Models\SaleOrderItem;
use App\Models\Stock;

class SaleForm extends Component
{
    public $customer_id;
    public $sale_date;
    public $branch_id;
    public $sale_order_id;
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
        $this->products = Product::all(); 
        $this->godowns = Godown::all();
        $this->saleOrders = [];
        $this->sale_date = now()->format('Y-m-d');
        $this->items[] = $this->createEmptyItem();
    }
    public function selectProduct($index, $productId)
    {
        // Find the selected product
        $product = $this->products->firstWhere('id', $productId);
    
        // If the product exists, update the selected item with the product's details
        if ($product) {
            $this->items[$index]['price'] = $product->price;  // Set the price
            $this->items[$index]['product_name'] = $product->product_name;  // Set the product name (if needed)
        }
    }
    
    public function updatedSaleOrderId($saleOrderId)
    {
        if ($saleOrderId) {
            $saleOrder = SaleOrder::with('items')->find($saleOrderId);

            if ($saleOrder) {
                $this->items = $saleOrder->items->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'discount' => $item->discount,
                        'godown_id' => $item->godown_id,
                        'sub_total' => $item->quantity * $item->price - ($item->quantity * $item->price * $item->discount / 100),
                    ];
                })->toArray();
            } else {
                $this->items = [];
            }
        } else {
            $this->items = [];
        }
    }

    

    public function updatedCustomerId($customerId)
    {
        $this->saleOrders = SaleOrder::where('customer_id', $customerId)->get();

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

    public function save()
    {
        $this->validate([
            'customer_id' => 'required|exists:customer_suppliers,id',
            'sale_date' => 'required|date',
            'branch_id' => 'required|exists:branches,id',
            'sale_order_id' => 'required|exists:sale_orders,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0|max:100',
            'items.*.godown_id' => 'required|exists:godowns,id',
        ]);

        $sale = Sale::create([
            'sale_no' => $this->saleOrderNo,
            'customer_id' => $this->customer_id,
            'sale_date' => $this->sale_date,
            'branch_id' => $this->branch_id,
            'sale_order_id' => $this->sale_order_id,
            'user_id' => Auth::id(),
        ]);

        foreach ($this->items as $item) {
            $item['user_id'] = Auth::id(); 
            $sale->items()->create($item);

            $stock = Stock::where('product_id', $item['product_id'])
                          ->where('branch_id', $this->branch_id)
                          ->first();

            if (!$stock || $stock->opening_stock < $item['quantity']) {
                toastr()->error('Insufficient stock for product: ' . Product::find($item['product_id'])->name);
                return;
            }
            $saleOrderItem = SaleOrderItem::where('sale_order_id',$sale->sale_order_id)
                                ->where('product_id',$item['product_id'])
                                ->first();
            if($saleOrderItem){
                // dd(saleOrderItem);
                $saleOrderItem->quantity = $saleOrderItem->quantity - $item['quantity'];
                $saleOrderItem->save();
            }
            $stock->decrement('opening_stock', $item['quantity']);
        }

        toastr()->success('Sale created successfully.');
        return redirect()->route('sales.index');
    }
    public function getFilteredGodownsProperty()
    {
        return $this->branch_id 
            ? $this->godowns->where('branch_id', $this->branch_id) 
            : collect([]);
    }
    public function render()
    {
        return view('livewire.inv-management.sale-form', [
            'products' => $this->products,
            'customers' => $this->customers,
            'branches' => $this->branches,
            'godowns' => $this->godowns,
            'filteredGodowns' => $this->filteredGodowns,
            'saleOrders' => $this->saleOrders,
        ]);
    }
}
