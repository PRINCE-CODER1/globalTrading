<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;
use Illuminate\Support\Facades\Auth;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('website.master.tax.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.master.tax.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|numeric',
        ]);

        Tax::create([
            'name' => $request->input('name'),
            'value' => $request->input('value'),
            'user_id' => Auth::id(), // Save the current user's ID
        ]);

        toastr()->closeButton(true)->success('Tax Created Successfully');
        return redirect()->route('taxes.index')->with('success', 'Tax created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tax = Tax::findOrFail($id);
        return view('website.master.tax.edit',compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tax $tax)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|numeric',
        ]);

        $tax->update([
            'name' => $request->input('name'),
            'value' => $request->input('value'),
            'user_id' => Auth::id(),
        ]);

        toastr()->closeButton(true)->success('Tax Updated Successfully');
        return redirect()->route('taxes.index')->with('success', 'Tax updated successfully.');
    }
}
