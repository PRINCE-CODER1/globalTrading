<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\StockCategory;
use App\Models\ChildCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeriesController extends Controller
{
    public function index()
    {
        return view('website.master.series.list');
    }

    public function create(Request $request)
    {
        $categories = StockCategory::all();
        $childCategories = [];
        if ($request->has('stock_category_id')) {
            $categoryId = $request->input('stock_category_id');
            $childCategories = ChildCategory::where('parent_category_id', $categoryId)->get();
        }

        return view('website.master.series.create', compact('categories', 'childCategories'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock_category_id' => 'required|exists:stock_categories,id',
            'child_category_id' => 'required|exists:child_categories,id', 
        ]);

        // Create a new series
        Series::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'stock_category_id' => $validatedData['stock_category_id'],
            'child_category_id' => $validatedData['child_category_id'] ?? null, 
            'user_id' => auth()->id(),
        ]);

        // Redirect to the series index page with a success message
        return redirect()->route('series.index')->with('success', 'Series created successfully.');
    }

    public function edit(Series $series)
    {
        $categories = StockCategory::all();
        $childCategories = ChildCategory::all(); // Fetch all child categories

        return view('website.master.series.edit', compact('series', 'categories', 'childCategories'));
    }

    public function update(Request $request, Series $series)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock_category_id' => 'required|exists:stock_categories,id',
            'child_category_id' => 'nullable|exists:child_categories,id',
        ]);

        // Update the series
        $series->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'stock_category_id' => $validatedData['stock_category_id'],
            'child_category_id' => $validatedData['child_category_id'] ?? null, // Handle optional child category
            'user_id' => Auth::id(), 
        ]);

        return redirect()->route('series.index')->with('success', 'Series updated successfully.');
    }

    public function destroy(Series $series)
    {
        $series->delete();
        return redirect()->route('series.index')->with('success', 'Series deleted successfully.');
    }
}
