<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChildCategory;
use App\Models\StockCategory;
use Illuminate\Support\Facades\Auth;

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $childCategories = ChildCategory::with('parentCategory')->paginate(10);
        return view('website.master.sub-category.list', compact('childCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = StockCategory::all();
        return view('website.master.sub-category.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_category_id' => 'required|exists:stock_categories,id',
        ]);

        ChildCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'parent_category_id' => $request->parent_category_id,
            'user_id' => Auth::id(),
        ]);

        toastr()->closeButton(true)->success('Child Category Created successfully.');
        return redirect()->route('child-categories.index');
    }

    public function edit(string $id)
    {
        $childCategory = ChildCategory::findOrFail($id);
        $parentCategories = StockCategory::all();
        return view('website.master.sub-category.edit', compact('childCategory', 'parentCategories'));
    }

    public function update(Request $request, string $id)
    {
        $childCategory = ChildCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_category_id' => 'required|exists:stock_categories,id',
        ]);

        $childCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'parent_category_id' => $request->parent_category_id,
            'user_id' => Auth::id(),
        ]);

        toastr()->closeButton(true)->success('Child Category Updated successfully.');
        return redirect()->route('child-categories.index');
    }
}
