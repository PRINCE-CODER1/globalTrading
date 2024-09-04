<?php

namespace App\Livewire\InvManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CustomerSupplier;
use App\Models\Branch;
use App\Models\SaleOrder;
use App\Models\Product;
use App\Models\Godown;
use App\Models\Sale;

class SaleEdit extends Component
{
    use WithPagination;

    public $sale;
    public $saleOrderNo;
    public $customers, $branches, $saleOrders, $products, $godowns;
    public $customer_id, $sale_date, $branch_id, $sale_order_id, $ref_no, $destination, $dispatch_through, $gr_no, $gr_date, $vehicle_no;
    public $items = [];
    public $no_of_boxes, $weight;

    protected $rules = [
        'customer_id' => 'required|exists:customer_suppliers,id',
        'sale_date' => 'required|date',
        'branch_id' => 'required|exists:branches,id',
        'sale_order_id' => 'required|exists:sale_orders,id',
        'ref_no' => 'nullable|string|max:255',
        'destination' => 'nullable|string|max:255',
        'dispatch_through' => 'nullable|string|max:255',
        'gr_no' => 'nullable|string|max:255',
        'gr_date' => 'nullable|date',
        'vehicle_no' => 'nullable|string|max:255',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|numeric|min:1',
        'items.*.price' => 'required|numeric|min:0',
        'items.*.discount' => 'nullable|numeric|min:0',
        'items.*.godown_id' => 'required|exists:godowns,id',
        'no_of_boxes' => 'required|numeric|min:1',
        'weight' => 'required|numeric|min:0',
    ];

    public function mount($saleId)
    {
        $this->sale = Sale::with('items')->find($saleId);
        if (!$this->sale) {
            abort(404);
        }

        $this->customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get();
        $this->branches = Branch::all();
        $this->saleOrders = SaleOrder::all();
        $this->products = Product::all();
        $this->godowns = Godown::all();
        
        $this->saleOrderNo = $this->sale->sale_no; 
        $this->customer_id = $this->sale->customer_id;
        $this->sale_date = $this->sale->sale_date;
        $this->branch_id = $this->sale->branch_id;
        $this->sale_order_id = $this->sale->sale_order_id;
        $this->ref_no = $this->sale->ref_no;
        $this->destination = $this->sale->destination;
        $this->dispatch_through = $this->sale->dispatch_through;
        $this->gr_no = $this->sale->gr_no;
        $this->gr_date = $this->sale->gr_date;
        $this->vehicle_no = $this->sale->vehicle_no;
        $this->no_of_boxes = $this->sale->no_of_boxes;
        $this->weight = $this->sale->weight;
        $this->items = $this->sale->items->toArray();
    }

    public function addItem()
    {
        $this->items[] = [
            'product_id' => '',
            'quantity' => '',
            'price' => '',
            'discount' => '',
            'godown_id' => ''
        ];
    }

    public function updatedCustomerId($customerId)
    {
        $this->saleOrders = SaleOrder::where('customer_id', $customerId)->get();
        if ($this->sale_order_id && !$this->saleOrders->contains('id', $this->sale_order_id)) {
            $this->sale_order_id = null;
        }
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function update()
    {
        $this->validate();

        $this->sale->update([
            'customer_id' => $this->customer_id,
            'sale_date' => $this->sale_date,
            'branch_id' => $this->branch_id,
            'sale_order_id' => $this->sale_order_id,
            'ref_no' => $this->ref_no,
            'destination' => $this->destination,
            'dispatch_through' => $this->dispatch_through,
            'gr_no' => $this->gr_no,
            'gr_date' => $this->gr_date,
            'vehicle_no' => $this->vehicle_no,
            'no_of_boxes' => $this->no_of_boxes,
            'weight' => $this->weight,
        ]);

        $this->sale->items()->delete();
        foreach ($this->items as $item) {
            if (!empty($item['product_id']) && !empty($item['quantity'])) {
                $this->sale->items()->create($item);
            }
        }

        toastr()->closeButton(true)->success('Updated successfully.');
        return redirect()->route('sales.index');
    }

    public function render()
    {
        return view('livewire.inv-management.sale-edit');
    }
}
