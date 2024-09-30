<?php 
namespace App\Livewire\Master;

use Livewire\Component;
use App\Models\StockCategory;  
use App\Models\ChildCategory;  
use App\Models\Series;
use Illuminate\Support\Facades\Auth;

class EditSeries extends Component
{
    public $seriesId;
    public $name;
    public $description;
    public $stock_category_id;
    public $child_category_id;

    public $categories = [];
    public $childCategories = [];

    public function mount($seriesId)
    {
        $series = Series::findOrFail($seriesId);

        // Populate form fields with the existing data
        $this->seriesId = $series->id;
        $this->name = $series->name;
        $this->description = $series->description;
        $this->stock_category_id = $series->stock_category_id;
        $this->child_category_id = $series->child_category_id;

        // Load categories and child categories
        $this->categories = StockCategory::all();
        $this->childCategories = ChildCategory::where('parent_category_id', $this->stock_category_id)->get();
    }

    public function render()
    {
        return view('livewire.master.edit-series');
    }

    public function updatedStockCategoryId($categoryId)
    {
        // Load child categories based on selected stock category
        $this->childCategories = ChildCategory::where('parent_category_id', $categoryId)->get();
        $this->child_category_id = null;  // Reset child category selection when stock category changes
    }

    public function update()
    {
        \Log::info('Updating series with values:', [
            'name' => $this->name,
            'description' => $this->description,
            'stock_category_id' => $this->stock_category_id,
            'child_category_id' => $this->child_category_id,
        ]);

        // Validate the form data
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock_category_id' => 'required|exists:stock_categories,id',
            'child_category_id' => 'required|exists:child_categories,id', // Adjust this if it's optional
        ]);

        // Find the series and update it
        $series = Series::findOrFail($this->seriesId);
        $series->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'stock_category_id' => $validatedData['stock_category_id'],
            'child_category_id' => $validatedData['child_category_id'],
        ]);

        session()->flash('message', 'Series updated successfully.');
        return redirect()->route('series.index');
    }
}
