<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\VisitMaster;

class VisitMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visits = VisitMaster::all();
        return view('website.master.visits-master.list', compact('visits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.master.visits-master.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'visitor_name' => 'required|string|max:255',
            'created_by' => 'required|exists:users,id',
        ]);

        VisitMaster::create($request->all());

        return redirect()->route('visits.index')->with('success', 'Visit created successfully.');
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
    public function edit(VisitMaster $visit)
    {
        return view('website.master.visits-master.edit', compact('visit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VisitMaster $visit)
    {
        $request->validate([
            'visitor_name' => 'required|string|max:255',
        ]);

        $visit->update($request->all());

        return redirect()->route('visits.index')->with('success', 'Visit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisitMaster $visit)
    {
        $visit->delete();

        return redirect()->route('visits.index')->with('success', 'Visit deleted successfully.');
    }
}
