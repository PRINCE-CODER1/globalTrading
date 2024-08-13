<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeadStatus;

class LeadStatusController extends Controller
{
    public function index()
    {
        $leads = LeadStatus::paginate(10); 
        return view('website.master.lead-status.list', compact('leads'));
    }

    public function create()
    {
        return view('website.master.lead-status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string',
            'details' => 'nullable|string',
        ]);

        LeadStatus::create($request->all());

        return redirect()->route('leads-status.index')->with('success', 'Lead Status created successfully.');
    }

    public function edit($id)
    {
        $lead = LeadStatus::findOrFail($id);
        return view('website.master.lead-status.edit', compact('lead'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string',
            'details' => 'nullable|string',
        ]);

        $lead = LeadStatus::findOrFail($id);
        $lead->update($request->all());

        return redirect()->route('leads-status.index')->with('success', 'Lead Status updated successfully.');
    }

    public function destroy($id)
    {
        $lead = LeadStatus::findOrFail($id);
        $lead->delete();

        return redirect()->route('leads-status.index')->with('success', 'Lead Status deleted successfully.');
    }
}
