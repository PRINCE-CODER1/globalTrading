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
    public $opening_stock;
    public $reorder_stock;
    public $branch_id;
    public $godown_id;
    public $unit_id;

    public $categories = [];
    public $childcategories = [];
    public $series = [];
    public $taxes = [];
    public $branches = [];
    public $godowns = [];
    public $units = [];

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
        $this->units = UnitOfMeasurement::all();

        // Initialize empty series and godowns as default
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
        $this->opening_stock = $product->opening_stock;
        $this->reorder_stock = $product->reorder_stock;
        $this->branch_id = $product->branch_id;
        $this->godown_id = $product->godown_id;
        $this->unit_id = $product->unit_id;

        // Update child categories and series based on the loaded product's category
        $this->childcategories = ChildCategory::where('parent_category_id', $this->product_category_id)->get();
        $this->series = Series::where('stock_category_id', $this->product_category_id)->get();
        
        // Update godowns based on the loaded product's branch
        $this->updateGodowns($this->branch_id);
    }

    public function updatedProductCategoryId($categoryId)
    {
        // Update child categories based on selected category
        $this->childcategories = ChildCategory::where('parent_category_id', $categoryId)->get();

        // Update series based on selected category
        $this->series = Series::where('stock_category_id', $categoryId)->get();
        $this->series_id = null; // Reset selected series
    }

    public function updatedChildCategoryId($childCategoryId)
    {
        // Update series based on selected child category
        $this->series = Series::where('child_category_id', $childCategoryId)->get();
        $this->series_id = null; 
    }

    public function updatedBranchId($branchId)
    {
        // Update godowns based on selected branch
        $this->updateGodowns($branchId);
    }

    private function updateGodowns($branchId)
    {
        $this->godowns = Godown::where('branch_id', $branchId)->get();
        $this->godown_id = null; // Reset selected godown
    }

    public function submit()
    {
        $validatedData = $this->validateData();

        Product::updateOrCreate(
            ['id' => $this->product_id],
            array_merge($validatedData, ['user_id' => Auth::id()])
        );

        $message = $this->product_id ? 'Product updated successfully.' : 'Product created successfully.';
        session()->flash('message', $message);

        return redirect()->route('products.index');
    }

    private function validateData()
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
            'opening_stock' => 'required|numeric',
            'reorder_stock' => 'required|numeric',
            'branch_id' => 'required|exists:branches,id',
            'godown_id' => 'required|exists:godowns,id',
            'unit_id' => 'required|exists:unit_of_measurements,id',
        ]);
    }

    public function render()
    {
        return view('livewire.master.product-form');
    }
}
