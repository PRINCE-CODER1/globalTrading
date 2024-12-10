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
use Illuminate\Validation\Rule;

class ProductEdit extends Component
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
    public $unit_id; // Added unit_id for product

    public $categories = [];
    public $childcategories = [];
    public $series = [];
    public $taxes = [];
    public $branches = [];
    public $godowns = [];
    public $units = []; // Added units of measurement

    public function mount(Product $product)
    {
        // Assign the necessary properties from the product model to the component's properties
        $this->product_id = $product->id;
        $this->product_category_id = $product->product_category_id;
        $this->child_category_id = $product->child_category_id;
        $this->series_id = $product->series_id;
        $this->product_name = $product->product_name;
        $this->product_description = $product->product_description;
        $this->tax = $product->tax;
        $this->hsn_code = $product->hsn_code;
        $this->price = $product->price;
        $this->product_code = $product->product_code;
        $this->opening_stock = optional($product->stock)->opening_stock ?? 0;
        $this->reorder_stock = optional($product->stock)->reorder_stock ?? 0;
        $this->branch_id = optional($product->stock)->branch_id ?? null;
        $this->updateGodowns($this->branch_id); 
        $this->godown_id = optional($product->stock)->godown_id;
        $this->unit_id = $product->unit_id; 

        // Load other necessary data
        $this->categories = StockCategory::all();
        $this->childcategories = ChildCategory::where('parent_category_id', $this->product_category_id)->get();
        $this->series = $this->child_category_id ? Series::where('child_category_id', $this->child_category_id)->get() : [];
        $this->taxes = Tax::all();
        $this->branches = Branch::all();
        $this->units = UnitOfMeasurement::all(); 

    }

    public function updatedProductCategoryId($categoryId)
    {
        $this->childcategories = ChildCategory::where('parent_category_id', $categoryId)->get();
        $this->child_category_id = null;
        $this->series = []; // Clear series when category changes
    }

    public function updatedChildCategoryId($childCategoryId)
    {
        $this->series = Series::where('child_category_id', $childCategoryId)->get();
        $this->series_id = null; // Reset selected series
    }

    public function updatedBranchId($branchId)
    {
        $this->updateGodowns($branchId);
    }

    private function updateGodowns($branchId)
    {
        $this->godowns = Godown::where('branch_id', $branchId)->get();
        $this->godown_id = null; // Reset godown selection
    }

    public function submit()
    {
        $validatedData = $this->validate([
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
            'unit_id' => 'required|exists:unit_of_measurements,id', // Validate unit_id
        ]);

        // Update product details
        Product::where('id', $this->product_id)->update($validatedData);
        
        toastr()->closeButton(true)->success('Product updated successfully.');
        return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.master.product-edit');
    }
}
