<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChallanType;

class ChallanTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('website.master.challan-types.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.master.challan-types.create');
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

        ChallanType::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(), 
        ]);
        toastr()->closeButton(true)->success('Challan Type Created successfully.');

        return redirect()->route('challan-types.index');
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $challanType = ChallanType::findOrFail($id);
        return view('website.master.challan-types.edit', compact('challanType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $challanType = ChallanType::findOrFail($id);
        $challanType->update($request->all());
        toastr()->closeButton(true)->success('Challan Type updated successfully.');

        return redirect()->route('challan-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
