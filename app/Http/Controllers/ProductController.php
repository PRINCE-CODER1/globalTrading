<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockCategory;
use App\Models\Branch;
use App\Models\Godown;
use App\Models\Series;
use App\Models\UnitOfMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('series')->get();
        return view('website.inventory-management.products.list',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
    */
    public function create()
    {
        $categories = StockCategory::all();
        $branches = Branch::all();
        $godowns = Godown::all();
        $units = UnitOfMeasurement::all();
        $series = Series::all();
        return view('website.inventory-management.products.create', compact('categories', 'branches', 'godowns', 'units','series'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_category_id' => 'required|exists:stock_categories,id',
            'tax' => 'nullable|numeric',
            'product_model' => 'nullable|string|max:255',
            'hsn_code' => 'required|string|max:255',
            'price' => 'required|numeric',
            'product_code' => 'required|string|max:255|unique:products',
            'opening_stock' => 'required|integer',
            'reorder_stock' => 'required|integer',
            'branch_id' => 'required|exists:branches,id',
            'godown_id' => 'required|exists:godowns,id',
            'unit_id' => 'required|exists:unit_of_measurements,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'series_id' => 'nullable|exists:series,id',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['received_at'] = $request->input('received_at') ?? now();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = StockCategory::all();
        $branches = Branch::all();
        $godowns = Godown::all();
        $units = UnitOfMeasurement::all();
        $series = Series::all();
        return view('website.inventory-management.products.edit', compact('product', 'categories', 'branches', 'godowns', 'units','series'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_category_id' => 'required|exists:stock_categories,id',
            'tax' => 'nullable|numeric',
            'product_model' => 'nullable|string|max:255',
            'hsn_code' => 'required|string|max:255',
            'price' => 'required|numeric',
            'product_code' => 'required|string|max:255|unique:products,product_code,' . $product->id,
            'opening_stock' => 'required|integer',
            'reorder_stock' => 'required|integer',
            'branch_id' => 'required|exists:branches,id',
            'godown_id' => 'required|exists:godowns,id',
            'unit_id' => 'required|exists:unit_of_measurements,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'series_id' => 'nullable|exists:series,id',
        ]);

        $validated['modified_by'] = Auth::id();
        $validated['received_at'] = $request->input('received_at') ?? $product->received_at;
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

}
