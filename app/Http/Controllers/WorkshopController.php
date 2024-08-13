<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Workshop;
use App\Models\Branch;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('website.master.workshop.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        return view('website.master.workshop.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $workshop = new Workshop($validatedData);
        $workshop->user_id = Auth::id();
        $workshop->save();
        toastr()->closeButton(true)->success('Workshop Created successfully');
        return redirect()->route('workshops.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $workshop = Workshop::findOrFail($id);
        $branches = Branch::all();
        return view('website.master.workshop.edit', compact('workshop', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workshop $workshop)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
        ]);
        $workshop->update([
            'name' => $validated['name'],
            'branch_id' => $validated['branch_id'],
            'user_id' => Auth::id(), 
        ]);
        toastr()->closeButton(true)->success('Workshop Updated successfully');
        return redirect()->route('workshops.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
