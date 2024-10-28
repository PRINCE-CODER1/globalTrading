<?php

namespace App\Livewire\Master;

use Livewire\Component;
use App\Models\StockCategory;
use App\Models\ChildCategory;
use App\Models\Series;
use App\Models\Tax;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Godown;
use App\Models\UnitOfMeasurement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductForm extends Component
{
    public $product_id;
    public $product_category_id;
    public $child_category_id;
    public $series_id;
    public $product_name;
    public $product_description;
    public $tax;
    public $hsn_code;
    public $price;
    public $product_code;

    // Stock Management Fields
    public $opening_stock;
    public $reorder_stock;
    public $branch_id;
    public $godown_id;
    public $unit_id; // Added unit_id for product

    public $categories = [];
    public $childcategories = [];
    public $series = [];
    public $taxes = [];
    public $branches = [];
    public $godowns = [];
    public $units = []; // To hold units of measurement

    public function mount($product_id = null)
    {
        $this->initializeData();

        if ($product_id) {
            $this->loadProductData($product_id);
        }
    }

    private function initializeData()
    {
        $this->categories = StockCategory::all();
        $this->taxes = Tax::all();
        $this->branches = Branch::all();
        $this->units = UnitOfMeasurement::all(); // Load units of measurement

        $this->series = [];
        $this->godowns = [];
    }

    private function loadProductData($product_id)
    {
        $this->product_id = $product_id;
        $product = Product::findOrFail($product_id);

        $this->product_category_id = $product->product_category_id;
        $this->child_category_id = $product->child_category_id;
        $this->series_id = $product->series_id;
        $this->product_name = $product->product_name;
        $this->product_description = $product->product_description;
        $this->tax = $product->tax;
        $this->hsn_code = $product->hsn_code;
        $this->price = $product->price;
        $this->product_code = $product->product_code;
        $this->unit_id = $product->unit_id; // Load unit for product

        // Update child categories and series based on the loaded product's category
        $this->childcategories = ChildCategory::where('parent_category_id', $this->product_category_id)->get();
        $this->series = Series::where('stock_category_id', $this->product_category_id)->get();

        // Load stock information if available
        $this->loadStockData($product_id);
    }

    private function loadStockData($product_id)
    {
        // Assuming Stock is a model representing stock data linked to Product
        $stock = \App\Models\Stock::where('product_id', $product_id)->first();

        if ($stock) {
            $this->opening_stock = $stock->opening_stock;
            $this->reorder_stock = $stock->reorder_stock;
            $this->branch_id = $stock->branch_id;
            $this->godown_id = $stock->godown_id;
        }
    }

    public function updatedProductCategoryId($categoryId)
    {
        $this->childcategories = ChildCategory::where('parent_category_id', $categoryId)->get();
        $this->series = Series::where('stock_category_id', $categoryId)->get();
        $this->series_id = null; // Reset selected series
    }

    public function updatedChildCategoryId($childCategoryId)
    {
        $this->series = Series::where('child_category_id', $childCategoryId)->get();
        $this->series_id = null;
    }

    public function updatedBranchId($branchId)
    {
        $this->updateGodowns($branchId);
    }

    private function updateGodowns($branchId)
    {
        $this->godowns = Godown::where('branch_id', $branchId)->get();
        $this->godown_id = null; // Reset selected godown
    }

    public function submit()
    {
        $validatedProductData = $this->validateProductData();
        $validatedStockData = $this->validateStockData();

        // Save or update the product
        $product = Product::updateOrCreate(
            ['id' => $this->product_id],
            array_merge($validatedProductData, ['user_id' => Auth::id()])
        );

        // Save or update stock data
        \App\Models\Stock::updateOrCreate(
            ['product_id' => $product->id],
            $validatedStockData
        );

        $message = $this->product_id ? 'Product updated successfully.' : 'Product created successfully.';
        toastr()->closeButton(true)->success($message);

        return redirect()->route('products.index');
    }

    private function validateProductData()
    {
        return $this->validate([
            'product_category_id' => 'required|exists:stock_categories,id',
            'child_category_id' => 'required|exists:child_categories,id',
            'series_id' => 'nullable|exists:series,id',
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'tax' => 'required|exists:taxes,value',
            'hsn_code' => 'required|string|max:255',
            'price' => 'required|numeric',
            'product_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'product_code')->ignore($this->product_id),
            ],
            'unit_id' => 'required|exists:unit_of_measurements,id', // Validate unit_id
        ]);
    }

    private function validateStockData()
    {
        return $this->validate([
            'opening_stock' => 'required|numeric',
            'reorder_stock' => 'required|numeric',
            'branch_id' => 'required|exists:branches,id',
            'godown_id' => 'required|exists:godowns,id',
        ]);
    }

    public function render()
    {
        return view('livewire.master.product-form');
    }
}
