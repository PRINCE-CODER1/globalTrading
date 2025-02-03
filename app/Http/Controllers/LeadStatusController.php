<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeadStatus;

class LeadStatusController extends Controller
{
    /**
     * Display a listing of the lead statuses.
     */
    public function index()
    {
        $leads = LeadStatus::paginate(10); // Paginate lead statuses
        return view('website.master.lead-status.list', compact('leads'));
    }

    /**
     * Show the form for creating a new lead status.
     */
    public function create()
    {
        return view('website.master.lead-status.create');
    }

    /**
     * Store a newly created lead status in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:50', // Limit status string length
            'details' => 'nullable|string|max:1000', // Add max length for details
            'color' => 'required|string|max:7|regex:/^#[a-fA-F0-9]{6}$/', // Ensure valid hex color
            'category' => 'required|string|in:open,closed,lost,completed',
        ]);

        LeadStatus::create($request->all());

        toastr()->closeButton(true)->success('Lead Status created successfully.');
        return redirect()->route('leads-status.index'); // Correct route name
    }

    /**
     * Show the form for editing the specified lead status.
     */
    public function edit($id)
    {
        $lead = LeadStatus::findOrFail($id); // Use findOrFail for safer lookup
        return view('website.master.lead-status.edit', compact('lead'));
    }

    /**
     * Update the specified lead status in the database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:50', // Ensure consistent validation with store
            'details' => 'nullable|string|max:1000',
            'color' => 'required|string|max:7|regex:/^#[a-fA-F0-9]{6}$/', // Validate hex color format
            'category' => 'required|string|in:open,closed,lost,completed',
        ]);

        $lead = LeadStatus::findOrFail($id);
        $lead->update($request->all());

        toastr()->closeButton(true)->success('Lead Status updated successfully.');
        return redirect()->route('leads-status.index'); // Correct route name
    }

    /**
     * Remove the specified lead status from the database.
     */
    public function destroy($id)
    {
        $lead = LeadStatus::findOrFail($id);
        $lead->delete();

        toastr()->closeButton(true)->success('Lead Status deleted successfully.');
        return redirect()->route('leads-status.index'); // Correct route name
    }
}
