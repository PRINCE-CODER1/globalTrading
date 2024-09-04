<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\CustomerSupplier;
use App\Models\Branch;
use App\Models\Godown;
use App\Models\Product;
use App\Models\SaleOrder;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with(['customer', 'branch', 'saleOrder'])->paginate(10);
        return view('website.inventory-management.sales.list', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get();
        $branches = Branch::all();
        $saleOrders = SaleOrder::all();
        $godown = Godown::all();
        $products = Product::all();

        return view('website.inventory-management.sales.create', compact('godown','products','customers', 'branches', 'saleOrders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sale_no' => 'required|string|max:255|unique:sales,sale_no',
            'customer_id' => 'required|exists:customer_suppliers,id',
            'sale_date' => 'required|date',
            'ref_no' => 'nullable|string|max:255',
            'destination' => 'nullable|string|max:255',
            'dispatch_through' => 'nullable|string|max:255',
            'gr_no' => 'nullable|string|max:255',
            'gr_date' => 'nullable|date',
            'weight' => 'nullable|numeric',
            'no_of_boxes' => 'nullable|integer',
            'vehicle_no' => 'nullable|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'sale_order_id' => 'required|exists:sale_orders,id',
            'user_id' => 'required|exists:users,id',
        ]);

        Sale::create($validatedData);

        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        return view('website.inventory-management.sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $customers = CustomerSupplier::all();
        $branches = Branch::all();
        $saleOrders = SaleOrder::all();
        $godown = Godown::all();

        return view('website.inventory-management.sales.edit', compact('sale', 'customers', 'branches', 'saleOrders','godown'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $validatedData = $request->validate([
            'sale_no' => 'required|string|max:255|unique:sales,sale_no,' . $sale->id,
            'customer_id' => 'required|exists:customer_suppliers,id',
            'sale_date' => 'required|date',
            'ref_no' => 'nullable|string|max:255',
            'destination' => 'nullable|string|max:255',
            'dispatch_through' => 'nullable|string|max:255',
            'gr_no' => 'nullable|string|max:255',
            'gr_date' => 'nullable|date',
            'weight' => 'nullable|numeric',
            'no_of_boxes' => 'nullable|integer',
            'vehicle_no' => 'nullable|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'sale_order_id' => 'required|exists:sale_orders,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $sale->update($validatedData);

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}
