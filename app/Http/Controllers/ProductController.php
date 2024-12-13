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
use App\Models\Stock; // Add Stock model
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductStockExport;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('series', 'stock')->get();
        return view('website.master.products.list', compact('products'));
    }
    public function stockReports(){
        $userId = auth()->id();
        $productreport = Product::withCount([
            'purchase',  // Count total purchases
            'sale' => function ($query) use ($userId) {
                $query->where('user_id', $userId);  // Filter sales by user ID
            }
        ])->get();
        return view('website.reports.stock-report',compact('productreport'));
    }
    // public function export($type)
    // {
    //     $userId = auth()->id();

    //     // Get filtered products
    //     $products = Product::with(['stock'])
    //         ->withCount([
    //             'purchase',
    //             'sale' => function ($query) use ($userId) {
    //                 $query->where('user_id', $userId);
    //             }
    //         ])
    //         ->when($this->search, function ($query) {
    //             $query->where('product_name', 'like', '%' . $this->search . '%');
    //         })
    //         ->get();

    //     // Export the data in the specified format
    //     if ($type == 'xlsx') {
    //         return Excel::download(new ProductStockExport($products), 'product_stock_report.xlsx');
    //     } elseif ($type == 'csv') {
    //         return Excel::download(new ProductStockExport($products), 'product_stock_report.csv');
    //     }

    //     return redirect()->route('stock-reports.index'); // Redirect back if no type is specified
    // }


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

        // Fetch all necessary data
        $categories = StockCategory::all();
        $branches = Branch::all();
        $godowns = Godown::all();
        $units = UnitOfMeasurement::all();
        $series = Series::all();
        $taxes = Tax::all(); // Corrected from tax to taxes (plural)

        return view('website.master.products.create', compact(
            'childcategories',
            'categories',
            'branches',
            'godowns',
            'units',
            'series',
            'taxes' // Correct variable name here
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate product-related fields
        $validatedProduct = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_category_id' => 'required|exists:stock_categories,id',
            'child_category_id' => 'nullable|exists:child_categories,id',
            // 'tax' => 'nullable|numeric',
            'hsn_code' => 'required|string|max:255',
            'price' => 'required|numeric',
            'product_code' => 'required|string|max:255|unique:products',
            'unit_id' => 'required|exists:unit_of_measurements,id',
            'series_id' => 'nullable|exists:series,id',
            'received_at' => 'nullable|date',
        ]);

        // Add current user ID and received date if not provided
        $validatedProduct['user_id'] = Auth::id();
        $validatedProduct['received_at'] = $request->input('received_at') ?? now();

        // Create the product
        $product = Product::create($validatedProduct);

        // Validate stock-related fields
        $validatedStock = $request->validate([
            'opening_stock' => 'required|integer|min:0',
            'reorder_stock' => 'required|integer|min:0',
            'branch_id' => 'required|exists:branches,id',
            'godown_id' => 'required|exists:godowns,id',
        ]);

        // Create stock entry for the product
        $validatedStock['product_id'] = $product->id;
        Stock::create($validatedStock); 

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
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

        // Fetch the stock data for this product
        $stock = $product->stock; // Ensure stock is loaded for this product

        return view('website.master.products.edit', compact(
            'product',
            'categories',
            'childcategories',
            'branches',
            'godowns',
            'units',
            'series',
            'taxes',
            'stock'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validate product-related fields
        $validatedProduct = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_category_id' => 'required|exists:stock_categories,id',
            'child_category_id' => 'nullable|exists:child_categories,id',
            // 'tax' => 'nullable|numeric',
            'hsn_code' => 'required|string|max:255',
            'price' => 'required|numeric',
            'product_code' => 'required|string|max:255|unique:products,product_code,' . $product->id,
            'unit_id' => 'required|exists:unit_of_measurements,id',
            'series_id' => 'nullable|exists:series,id',
            'received_at' => 'nullable|date',
        ]);

        // Add the ID of the user making the update
        $validatedProduct['modified_by'] = Auth::id();
        $validatedProduct['received_at'] = $request->input('received_at') ?? $product->received_at;

        // Update the product
        $product->update($validatedProduct);

        // Validate stock-related fields
        $validatedStock = $request->validate([
            'opening_stock' => 'required|integer|min:0',
            'reorder_stock' => 'required|integer|min:0',
            'branch_id' => 'required|exists:branches,id',
            'godown_id' => 'required|exists:godowns,id',
        ]);

        // Update stock entry
        if ($product->stock) {
            $product->stock()->update($validatedStock);  // Assuming you have a stock relationship in Product model
        } else {
            $validatedStock['product_id'] = $product->id;
            Stock::create($validatedStock); // Create stock if it doesn't exist
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
}
