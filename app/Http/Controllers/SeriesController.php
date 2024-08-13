<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Series::where('dismantling_required', false)->with('user')->get();
        return view('website.master.series.list', compact('series'));
    }

    public function create()
    {
        return view('website.master.series.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_rate' => 'nullable|numeric|min:0|max:100',
            'dismantling_required' => 'nullable|boolean',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        Series::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'discount_rate' => $request->input('discount_rate'),
            'dismantling_required' => $request->boolean('dismantling_required'),
            'tax_rate' => $request->input('tax_rate'),
            'user_id' => Auth::id(), // Use Auth::id() for consistency
        ]);

        return redirect()->route('series.index')->with('success', 'Series created successfully.');
    }

    public function edit(Series $series)
    {
        return view('website.master.series.edit', compact('series'));
    }

    public function update(Request $request, Series $series)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_rate' => 'nullable|numeric|min:0|max:100',
            'dismantling_required' => 'nullable|boolean',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        $series->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'discount_rate' => $request->input('discount_rate'),
            'dismantling_required' => $request->boolean('dismantling_required'),
            'tax_rate' => $request->input('tax_rate'),
            'user_id' => Auth::id(), // Use Auth::id() for consistency
        ]);

        return redirect()->route('series.index')->with('success', 'Series updated successfully.');
    }

    public function destroy(Series $series)
    {
        $series->delete();
        return redirect()->route('series.index')->with('success', 'Series deleted successfully.');
    }
}
