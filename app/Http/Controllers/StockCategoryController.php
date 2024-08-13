<?php

namespace App\Http\Controllers;

use App\Models\StockCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class StockCategoryController extends Controller
{
    public function index()
    {
        // $categories = StockCategory::with('parent')->paginate(10);
        return view('website.master.stock-category.list');
    }

    public function create()
    {
        $categories = StockCategory::all();
        return view('website.master.stock-category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'parent_id' => 'nullable|exists:stock_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $validatedData['user_id'] = Auth::id();
        StockCategory::create($validatedData);
        toastr()->closeButton(true)->success('Category Created successfully.');
        return redirect()->route('stocks-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {

        $stockCategory = StockCategory::findOrFail($id);
        $categories = StockCategory::where('id', '!=', $id)->get();
        return view('website.master.stock-category.edit', compact('stockCategory', 'categories'));
    }
    
    public function update(Request $request, $id)
    {
        $stockCategory = StockCategory::findOrFail($id);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'parent_id' => 'nullable|exists:stock_categories,id', // Ensure parent_id exists in the stock_categories table
            'name' => 'required|string|max:255|',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            toastr()->closeButton(true)->error('Stock Category not updated.');
            return redirect()->route('stocks-categories.edit', $id)->withErrors($validator)->withInput();
        }

        // Update stock category details
        $stockCategory->name = $request->name;
        $stockCategory->description = $request->description;
        $stockCategory->parent_id = $request->parent_id;
        $stockCategory->user_id = Auth::id();
        $stockCategory->save();

        toastr()->closeButton(true)->success('Stock Category updated successfully.');
        return redirect()->route('stocks-categories.index');
    }
    

    // public function destroy(StockCategory $stockCategory)
    // {
    //     $stockCategory->delete();

    //     return redirect()->route('stocks-categories.index')->with('success', 'Category deleted successfully.');
    // }
}
