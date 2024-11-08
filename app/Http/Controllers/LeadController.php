<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\CustomerSupplier;
use App\Models\LeadStatus;
use App\Models\LeadSource;
use App\Models\Segment;
use App\Models\Remark;
use App\Models\LeadLog;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;


class LeadController extends Controller implements HasMiddleware
{
    public static function middleware(): array{
        return [
            new Middleware('permission:view lead', only: ['index']),
            new Middleware('permission:edit lead', only: ['edit']),
            new Middleware('permission:create lead', only: ['create']),
            new Middleware('permission:delete lead', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();
    
        $leads = Lead::where('assigned_to',$userId)
                ->with('remarks')
                ->get();
        $agentID = 0;
        return view('agent-dash.leads.list', compact('leads', 'agentID'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leadStatuses = LeadStatus::all();
        $leadSources = LeadSource::all();
        $segments = Segment::whereNull('parent_id')->get();
        $subSegments = Segment::whereNotNull('parent_id')->get();
        $customers = CustomerSupplier::where('customer_supplier', 'onlyCustomer')->get();

        return view('agent-dash.leads.create', compact('subSegments', 'leadStatuses', 'leadSources', 'segments', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // Store method
public function store(Request $request)
{
    $request->validate([
        'customer_id' => 'required|exists:customer_suppliers,id',
        'lead_status_id' => 'required|exists:lead_statuses,id',
        'lead_source_id' => 'required|exists:lead_sources,id',
        'segment_id' => 'required|exists:segments,id',
        'sub_segment_id' => 'nullable|exists:segments,id',
        'expected_date' => 'required|date',
        'remark' => 'nullable|string',
    ]);

    $lead = Lead::create([
        'customer_id' => $request->customer_id,
        'lead_status_id' => $request->lead_status_id,
        'lead_source_id' => $request->lead_source_id,
        'segment_id' => $request->segment_id,
        'sub_segment_id' => $request->sub_segment_id,
        'expected_date' => $request->expected_date,
        'assigned_to' => auth()->id(),
        'user_id' => auth()->id(),
    ]);

    if ($request->filled('remark')) { 
        Remark::create([
            'lead_id' => $lead->id,
            'user_id' => auth()->id(),
            'remark' => $request->remark,
        ]);
    }

    // Log the lead creation
    LeadLog::create([
        'lead_id' => $lead->id,
        'id_from' => auth()->id(),
        'log_type' => 'lead_created',
        'details' => 'Lead created with ID ' . $lead->id,
        'id_to' => null,
    ]);


    return redirect()->route('agent.leads.index')->with('success', 'Lead added successfully');
}

// Update method
public function update(Request $request, Lead $lead)
{
    $request->validate([
        'customer_id' => 'required|exists:customer_suppliers,id',
        'lead_status_id' => 'required|exists:lead_statuses,id',
        'lead_source_id' => 'required|exists:lead_sources,id',
        'segment_id' => 'required|exists:segments,id',
        'sub_segment_id' => 'nullable|exists:segments,id',
        'expected_date' => 'required|date',
        'remark' => 'nullable|string',
    ]);

    $oldAssignedTo = $lead->assigned_to;

    // Update lead details
    $lead->update([
        'customer_id' => $request->customer_id,
        'lead_status_id' => $request->lead_status_id,
        'lead_source_id' => $request->lead_source_id,
        'segment_id' => $request->segment_id,
        'sub_segment_id' => $request->sub_segment_id,
        'expected_date' => $request->expected_date,
    ]);

    // Create or update remark if provided
    if ($request->filled('remark')) {
        Remark::create([
            'lead_id' => $lead->id,
            'user_id' => auth()->id(),
            'remark' => $request->remark,
        ]);
    }

    // Log the lead update
    if ($lead->assigned_to !== $oldAssignedTo) {
        LeadLog::create([
            'lead_id' => $lead->id,
            'id_from' => $oldAssignedTo,
            'id_to' => $lead->assigned_to,
            'log_type' => 'lead_reassigned',
            'details' => 'Lead reassigned from user ID ' . $oldAssignedTo . ' to user ID ' . $lead->assigned_to,
        ]);
    }

    LeadLog::create([
        'lead_id' => $lead->id,
        'id_from' => auth()->id(),
        'log_type' => 'lead_updated',
        'details' => 'Lead updated with ID ' . $lead->id,
        'id_to' => null,
    ]);

    return redirect()->route('agent.leads.index')->with('success', 'Lead updated successfully.');
}

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
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        // Log the lead deletion
        LeadLog::create([
            'lead_id' => $lead->id,
            'id_from' => auth()->id(),
            'log_type' => 'lead_deleted',
            'details' => 'Lead deleted with ID ' . $lead->id,
            'id_to' => null,
        ]);

        // Optionally, delete associated remarks
        $lead->remarks()->delete();

        $lead->delete();
        return redirect()->route('agent.leads.index')->with('success', 'Lead deleted successfully.');
    }

    public function leadByAgent($agentID)
    {
        return view('agent-dash.leads.list',['agentID' => $agentID]);
    }

}