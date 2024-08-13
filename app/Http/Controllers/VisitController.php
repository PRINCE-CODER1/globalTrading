<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    // Display a list of visits
    public function index()
    {
        $visits = Visit::orderBy('visit_date', 'desc')->paginate(10); // Paginate if needed
        return view('website.master.visits.list', compact('visits'));
    }

    // Show the form for creating a new visit
    public function create()
    {
        $products = Product::all(); // Get all products for the dropdown
        return view('website.master.visits.create', compact('products'));
    }

    // Store a newly created visit in the database
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'visit_date' => 'required|date',
            'location' => 'required|string',
            'purpose' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        Visit::create([
            'product_id' => $request->input('product_id'),
            'user_id' => Auth::id(),
            'visit_date' => $request->input('visit_date'),
            'location' => $request->input('location'),
            'purpose' => $request->input('purpose'),
            'notes' => $request->input('notes'),
        ]);

        return redirect()->route('visits.index')->with('success', 'Visit added successfully.');
    }
    public function edit($id)
    {
        $visit = Visit::findOrFail($id);
        $products = Product::all(); // Fetch all products to populate the dropdown

        return view('website.master.visits.edit', compact('visit', 'products'));
    }

    // Update the specified visit in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'visit_date' => 'required|date',
            'location' => 'required|string',
            'purpose' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $visit = Visit::findOrFail($id);
        $visit->update([
            'product_id' => $request->input('product_id'),
            'visit_date' => $request->input('visit_date'),
            'location' => $request->input('location'),
            'purpose' => $request->input('purpose'),
            'notes' => $request->input('notes'),
        ]);

        return redirect()->route('visits.index')
                        ->with('success', 'Visit updated successfully.');
    }

    // Remove the specified visit from the database
    public function destroy(Visit $visit)
    {
        $visit->delete();
        return redirect()->route('visits.index')->with('success', 'Visit deleted successfully.');
    }
}
