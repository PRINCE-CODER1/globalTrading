<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockCategory;
use App\Models\ChildCategory;
use App\Models\Branch;
use App\Models\Godown;
use App\Models\Series;
use App\Models\Tax;
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
        return view('website.master.products.list',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
    */
    public function create(Request $request)
    {
        $childcategories = [];
        if ($request->has('product_category_id')) {
            $categoryId = $request->input('product_category_id');
            $childcategories = ChildCategory::where('parent_category_id', $categoryId)->get();
        }
        $categories = StockCategory::all();
        $childcategories = ChildCategory::all();
        $branches = Branch::all();
        $godowns = Godown::all();
        $units = UnitOfMeasurement::all();
        $series = Series::all();
        $tax = Tax::all();
        return view('website.master.products.create', compact('childcategories','categories','childcategories', 'branches', 'godowns', 'units','series','tax'));
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
            'child_category_id' => 'nullable|exists:child_categories,id',
            'tax' => 'nullable|numeric',
            'hsn_code' => 'required|string|max:255',
            'price' => 'required|numeric',
            'product_code' => 'required|string|max:255|unique:products',
            'opening_stock' => 'required|integer',
            'reorder_stock' => 'required|integer',
            'branch_id' => 'required|exists:branches,id',
            'godown_id' => 'required|exists:godowns,id',
            'unit_id' => 'required|exists:unit_of_measurements,id',
            'series_id' => 'nullable|exists:series,id',
            'received_at' => 'nullable|date',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['received_at'] = $request->input('received_at') ?? now();

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }


    public function edit(Product $product)
    {
        // Fetch all necessary data
        $categories = StockCategory::all();
        $childcategories = ChildCategory::all();
        $branches = Branch::all();
        $godowns = Godown::all();
        $units = UnitOfMeasurement::all();
        $series = Series::all();
        $taxes = Tax::all();

        return view('website.master.products.edit', compact(
            'product',
            'categories',
            'childcategories',
            'branches',
            'godowns',
            'units',
            'series',
            'taxes'
        ));
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
            'child_category_id' => 'nullable|exists:child_categories,id',
            'tax' => 'nullable|numeric',
            'hsn_code' => 'required|string|max:255',
            'price' => 'required|numeric',
            'product_code' => 'required|string|max:255|unique:products,product_code,' . $product->id,
            'opening_stock' => 'required|integer',
            'reorder_stock' => 'required|integer',
            'branch_id' => 'required|exists:branches,id',
            'godown_id' => 'required|exists:godowns,id',
            'unit_id' => 'required|exists:unit_of_measurements,id',
            'series_id' => 'nullable|exists:series,id',
            'received_at' => 'nullable|date',
        ]);

        $validated['modified_by'] = Auth::id();
        $validated['received_at'] = $request->input('received_at') ?? $product->received_at;

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

}
