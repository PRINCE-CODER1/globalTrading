<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleType;
use Illuminate\Support\Facades\Auth;

class SaleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('website.master.sale-types.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.master.sale-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        SaleType::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(), 
        ]);
        toastr()->closeButton(true)->success('Sale Type Created Successfully');
        return redirect()->route('sale-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $saleType = SaleType::findOrFail($id);
        return view('website.master.sale-types.edit', compact('saleType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaleType $saleType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $saleType->update($request->all());
        toastr()->closeButton(true)->success('Sale Type Updated Successfully');

        return redirect()->route('sale-types.index')->with('success', 'Sale type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
