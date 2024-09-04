<?php 
namespace App\Livewire\Master;

use Livewire\Component;
use App\Models\StockCategory;  
use App\Models\ChildCategory;  
use App\Models\Series;
use Illuminate\Support\Facades\Auth; 

class CreateSeries extends Component
{
    public $name;
    public $description;
    public $stock_category_id;
    public $child_category_id;

    public $categories = [];
    public $childCategories = [];

    public function mount()
    {
        $this->categories = StockCategory::all();
    }

    public function render()
    {
        return view('livewire.master.create-series');
    }

    public function updatedStockCategoryId($categoryId)
    {
        $this->childCategories = ChildCategory::where('parent_category_id', $categoryId)->get();
        
        // Uncomment the line below if you want to clear the child category selection
        // $this->child_category_id = null; 

        \Log::info('Updated stock category:', ['categoryId' => $categoryId, 'childCategories' => $this->childCategories]);
    }

    public function submit()
    {
        \Log::info('Submitting form with values:', [
            'name' => $this->name,
            'description' => $this->description,
            'stock_category_id' => $this->stock_category_id,
            'child_category_id' => $this->child_category_id,
        ]);

        // Adjust validation rules if child_category_id is optional
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock_category_id' => 'required|exists:stock_categories,id',
            'child_category_id' => 'required|exists:child_categories,id', // Made child_category_id optional
        ]);

        Series::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'stock_category_id' => $validatedData['stock_category_id'],
            'child_category_id' => $validatedData['child_category_id'],
            'user_id' => Auth::id(),
        ]);

        session()->flash('message', 'Series created successfully.');
        return redirect()->route('series.index');
    }
}
