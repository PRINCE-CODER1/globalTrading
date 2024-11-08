<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeadType;

class LeadTypeController extends Controller
{
    public function index(){
        $leadTypes = LeadType::all();
        return view('website.master.lead-types.list',compact('leadTypes'));
    }
    public function create()
    {
        return view('website.master.lead-types.create');
    }
    public function edit($id)
    {
        $lead = LeadType::findOrFail($id);
        return view('website.master.lead-types.edit',compact('lead'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        LeadType::create($request->all());

        toastr()->closeButton()->success('Lead Type created successfully.');
        return redirect()->route('leads-types.index');
    }
    // Update the specified lead type in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        $lead = LeadType::findOrFail($id);
        $lead->update($request->all());
        toastr()->closeButton()->success('Lead Type updated successfully.');

        return redirect()->route('leads-types.index');
    }

}
