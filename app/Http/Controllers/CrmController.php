<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\CustomerSupplier;

class CrmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Fetch recent leads with customer and lead source relationships
    $recentLeads = Lead::with('customer', 'leadSource', 'assignedAgent')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    // Get the lead source breakdown data
    $leadSourceData = $this->getLeadSourceData();

    // Get the lead assignment data
    $leadAssignmentData = $this->getLeadAssignmentData();

    // Fetch customers with the condition of 'onlySupplier'
    $customers = CustomerSupplier::where('customer_supplier', 'onlySupplier')->get();

    // Fetch all lead sources
    $leadSources = LeadSource::all();

    // Pass data to the view
    return view('website.crm.index', compact(
        'recentLeads',
        'leadSourceData',
        'leadAssignmentData',
        'customers',
        'leadSources',
    ));
}

    // Fetch lead source data for the pie chart
    private function getLeadSourceData()
    {
        return Lead::selectRaw('lead_source_id, COUNT(*) as count')
            ->groupBy('lead_source_id')
            ->with('leadSource') // Load related LeadSource data
            ->get()
            ->map(function ($lead) {
                return [
                    'source' => $lead->leadSource->name,
                    'count' => $lead->count,
                ];
            });
    }

    // Fetch lead assignment data for the overview table
    private function getLeadAssignmentData()
    {
        return Lead::selectRaw('assigned_to, COUNT(*) as count')
            ->groupBy('assigned_to')
            ->get()
            ->map(function ($lead) {
                return [
                    'assigned_to' => $lead->assignedAgent->name,
                    'count' => $lead->count,
                ];
            });
    }
}
