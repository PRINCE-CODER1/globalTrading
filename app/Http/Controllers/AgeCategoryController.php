<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\stockAgingMaster;

class AgeCategoryController extends Controller
{
    public function index()
    {
        $categories = stockAgingMaster::all();
        return view('website.master.stock-aging-manage.list', compact('categories'));
    }

    public function create()
    {
        return view('website.master.stock-aging-manage.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'days' => 'required|string|max:255',
        ]);

        stockAgingMaster::create($request->all());

        return redirect()->route('age_categories.index')->with('success', 'Age category created successfully.');
    }
}
