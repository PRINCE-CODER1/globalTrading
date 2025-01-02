<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Segment;
use App\Models\Branch;
use App\Models\Product;
use App\Models\SaleOrder;
use App\Models\SaleOrderItem;
use App\Models\LeadSource;
use App\Models\CustomerSupplier;
use App\Models\MasterNumbering;

class SaleOrderController extends Controller
{
    public function index()
    {
        return view('website.inventory-management.sale-orders.list');
    }

    public function create()
    {
        // Fetch the necessary data
        $products = Product::all();
        $suppliers = CustomerSupplier::where('customer_supplier', 'onlySupplier')->get();
        $customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get();
        $agents = User::where('role', 'Agent')->get();
        $segments = Segment::all();
        $branches = Branch::all();
        $leadSources = LeadSource::all();

        // Fetch the master numbering
        $masterNumbering = MasterNumbering::first();
        if (!$masterNumbering) {
            return redirect()->back()->withErrors(['error' => 'Master numbering not found.']);
        }

        // Generate the Sale Order No
        $currentFormat = $masterNumbering->sale_order_format;
        preg_match('/(\d+)/', $currentFormat, $matches);
        $number = isset($matches[0]) ? intval($matches[0]) : 0;
        $number += 1; // Increment the number
        $saleOrderNo = sprintf("SO/%03d/BI", $number);

        return view('website.inventory-management.sale-orders.create', compact('products', 'suppliers', 'customers', 'agents', 'segments', 'branches', 'leadSources', 'saleOrderNo'));
    }

    public function saleOrderReports(){
        return view('website.reports.sale-order-report');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'customer_id' => 'required|exists:customer_suppliers,id',
            'agent_id' => 'required|exists:users,id',
            'segment_id' => 'required|exists:segments,id',
            'lead_source_id' => 'required|exists:lead_sources,id',
            'order_branch_id' => 'required|exists:branches,id',
            'delivery_branch_id' => 'required|exists:branches,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.expected_date' => 'required|date',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.discount' => 'nullable|numeric|min:0|max:100',
        ]);

        // Generate the Sale Order No
        $masterNumbering = MasterNumbering::first();
        if (!$masterNumbering) {
            return redirect()->back()->withErrors(['error' => 'Master numbering not found.']);
        }

        // Increment the number for the new sale order
        preg_match('/(\d+)/', $masterNumbering->sale_order_format, $matches);
        $number = isset($matches[0]) ? intval($matches[0]) : 0;
        $number += 1; // Increment the number
        $saleOrderNo = sprintf("SO/%03d/BI", $number);

        // Create Sale Order
        $saleOrder = SaleOrder::create([
            'sale_order_no' => $saleOrderNo,
            'date' => $request->date,
            'customer_id' => $request->customer_id,
            'agent_id' => $request->agent_id,
            'segment_id' => $request->segment_id,
            'lead_source_id' => $request->lead_source_id,
            'order_branch_id' => $request->order_branch_id,
            'delivery_branch_id' => $request->delivery_branch_id,
            'user_id' => auth()->id(),
        ]);

        // Create Sale Order Items
        foreach ($request->products as $product) {
            $saleOrder->items()->create([
                'product_id' => $product['product_id'],
                'expected_date' => $product['expected_date'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'discount' => $product['discount'] ?? 0,
                'sub_total' => $product['quantity'] * $product['price'] * (1 - ($product['discount'] ?? 0) / 100),
                'user_id' => auth()->id(),
            ]);
        }

        // Update MasterNumbering with the new format
        $masterNumbering->update(['sale_order_format' => sprintf("SO/%03d/BI", $number)]);

        return redirect()->route('sale_orders.index')->with('success', 'Sale order created successfully!');
    }

    public function edit(string $id)
    {
        $saleOrder = SaleOrder::with('items.product')->findOrFail($id);
        $products = Product::all();
        $customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get();
        $agents = User::all();
        $segments = Segment::all();
        $branches = Branch::all();
        $leadSources = LeadSource::all();

        return view('website.inventory-management.sale-orders.edit', compact('saleOrder', 'products', 'customers', 'agents', 'segments', 'branches', 'leadSources'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'customer_id' => 'nullable|exists:customer_suppliers,id',
            'agent_id' => 'required|exists:users,id',
            'segment_id' => 'required|exists:segments,id',
            'order_branch_id' => 'required|exists:branches,id',
            'delivery_branch_id' => 'required|exists:branches,id',
            'lead_source_id' => 'nullable|exists:lead_sources,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.expected_date' => 'nullable|date',
            'products.*.quantity' => 'required|numeric|min:0',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.discount' => 'nullable|numeric|min:0|max:100',
            'products.*.sub_total' => 'nullable|numeric|min:0',
        ]);

        $saleOrder = SaleOrder::findOrFail($id);
        $saleOrder->update([
            'date' => $request->date,
            'customer_id' => $request->customer_id,
            'agent_id' => $request->agent_id,
            'segment_id' => $request->segment_id,
            'order_branch_id' => $request->order_branch_id,
            'delivery_branch_id' => $request->delivery_branch_id,
            'lead_source_id' => $request->lead_source_id,
        ]);

        // Remove existing items
        SaleOrderItem::where('sale_order_id', $saleOrder->id)->delete();

        // Save new Sale Order Items
        foreach ($request->products as $product) {
            SaleOrderItem::create([
                'sale_order_id' => $saleOrder->id,
                'product_id' => $product['product_id'],
                'expected_date' => $product['expected_date'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'discount' => $product['discount'] ?? 0,
                'sub_total' => $product['sub_total'] ?? $product['quantity'] * $product['price'] * (1 - ($product['discount'] ?? 0) / 100),
                'user_id' => auth()->id(),
            ]);
        }

        toastr()->closeButton(true)->success('Sale Order updated successfully.');
        return redirect()->route('sale_orders.index');
    }

    public function destroy($id)
    {
        $saleOrder = SaleOrder::findOrFail($id);
        SaleOrderItem::where('sale_order_id', $id)->delete();
        $saleOrder->delete();

        return redirect()->route('sale_orders.index')->with('success', 'Sale Order deleted successfully.');
    }
}
