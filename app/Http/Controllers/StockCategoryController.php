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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        StockCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        toastr()->closeButton(true)->success('Parent Category Created successfully.');
        return redirect()->route('stocks-categories.index');
    }

    public function edit($id)
    {

        $stockCategory = StockCategory::findOrFail($id);
        $categories = StockCategory::where('id', '!=', $id)->get();
        return view('website.master.stock-category.edit', compact('stockCategory', 'categories'));
    }
    
    public function update(Request $request, $id)
    {
        $parentCategory = StockCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $parentCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        toastr()->closeButton(true)->success('Parent Category Updated successfully.');
        return redirect()->route('parent-categories.index');
    }
    

    // public function destroy(StockCategory $stockCategory)
    // {
    //     $stockCategory->delete();

    //     return redirect()->route('stocks-categories.index')->with('success', 'Category deleted successfully.');
    // }
}
