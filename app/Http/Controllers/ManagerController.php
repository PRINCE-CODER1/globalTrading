<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lead;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leads = Lead::all();
        return view('manager.manager-dash.index',compact('leads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function showLeads($userId)
    {
        $user = User::find($userId);

        // Ensure the user exists
        if (!$user) {
            abort(404, 'User not found');
        }

        // Fetch leads and handle if no leads are found
        $leads = collect($user->leads);


        return view('manager.team.agent-det', compact('user', 'leads'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the lead with the assigned agent relationship
        $lead = Lead::with('assignedAgent.teams')->findOrFail($id);

        // Fetch related data
        $leadStatuses = LeadStatus::all(); // Fetch all lead statuses
        $leadSources = LeadSource::all(); // Fetch all lead sources
        $segments = Segment::whereNull('parent_id')->get(); // Fetch parent segments
        $subSegments = Segment::where('parent_id', $lead->segment_id)->get(); // Fetch sub-segments based on selected segment
        $customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get(); // Fetch customers

        // Fetch all remarks with associated user info and order by created_at
        $remarks = $lead->remarks()->with('user')->orderBy('created_at', 'asc')->get();
        
        // Determine the latest remark, if available
        $currentRemark = $remarks->last();

        return view('agent-dash.leads.edit', [
            'lead' => $lead,
            'remarks' => $remarks,
            'currentRemark' => $currentRemark,
            'leadStatuses' => $leadStatuses,
            'leadSources' => $leadSources,
            'segments' => $segments,
            'subSegments' => $subSegments,
            'customers' => $customers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
