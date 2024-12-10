<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use App\Models\Lead;
use App\Models\LeadStatus;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class AgentDashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $leadsPerDay = []; // Store leads data for graph
    public $perPage = 10; // Leads per page
    public $selectedRange = 'day'; // Default time range

    public function mount()
    {
        // Fetch leads data for the default range (day)
        $this->fetchLeadsData($this->selectedRange);
    }

    public function render()
    {
        $user = Auth::user();

        // Fetch the agent's leads
        $leads = Lead::with(['customer', 'leadStatus', 'leadSource'])
            ->where('assigned_to', $user->id) // Fetch leads assigned to the agent
            ->when($this->statusFilter, function($query) {
                $query->whereHas('leadStatus', function ($q) {
                    $q->where('name', $this->statusFilter);
                });
            })
            ->where(function ($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhere('reference_id', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);
            $statuses = LeadStatus::all();

        return view('livewire.crm.agent-dashboard', compact('leads','statuses'));
    }

    public function fetchLeadsData($range)
    {
        $this->leadsPerDay = []; // Clear existing data

        // Fetch leads based on selected time range and filter for assigned agent
        switch ($range) {
            case 'week':
                $this->leadsPerDay = Lead::selectRaw('DATE(created_at) as date, 
                        SUM(CASE WHEN lead_status_id = 1 THEN 1 ELSE 0 END) as new_leads, 
                        SUM(CASE WHEN lead_status_id = 2 THEN 1 ELSE 0 END) as completed_leads , 
                        SUM(CASE WHEN lead_status_id = 3 THEN 1 ELSE 0 END) as in_progress_leads,  
                        SUM(CASE WHEN lead_status_id = 4 THEN 1 ELSE 0 END) as lost_leads')
                    ->where('assigned_to', Auth::id()) // Fetch leads assigned to the logged-in agent
                    ->where('created_at', '>=', now()->subWeek())
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
                break;

            case 'month':
                $this->leadsPerDay = Lead::selectRaw('DATE(created_at) as date, 
                        SUM(CASE WHEN lead_status_id = 1 THEN 1 ELSE 0 END) as new_leads, 
                        SUM(CASE WHEN lead_status_id = 2 THEN 1 ELSE 0 END) as completed_leads , 
                        SUM(CASE WHEN lead_status_id = 3 THEN 1 ELSE 0 END) as in_progress_leads,  
                        SUM(CASE WHEN lead_status_id = 4 THEN 1 ELSE 0 END) as lost_leads')
                    ->where('assigned_to', Auth::id()) // Filter by assigned agent
                    ->where('created_at', '>=', now()->subMonth())
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
                break;

            default: // Day
                $this->leadsPerDay = Lead::selectRaw('DATE(created_at) as date, 
                        SUM(CASE WHEN lead_status_id = 1 THEN 1 ELSE 0 END) as new_leads, 
                        SUM(CASE WHEN lead_status_id = 2 THEN 1 ELSE 0 END) as completed_leads , 
                        SUM(CASE WHEN lead_status_id = 3 THEN 1 ELSE 0 END) as in_progress_leads, 
                        SUM(CASE WHEN lead_status_id = 4 THEN 1 ELSE 0 END) as lost_leads')
                    ->where('assigned_to', Auth::id()) 
                    ->where('created_at', '>=', now()->subDay())
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
                break;
        }

        // Update the chart data
        $this->updateChartData();
    }


    public function updateChartData()
    {
        // Prepare data for the chart
        $this->dispatch('leadsDataUpdated', $this->leadsPerDay); // Changed to dispatch
    }

    public function updatedSelectedRange($value)
    {
        // Fetch leads data when the range changes
        $this->fetchLeadsData($value);
    }
    public function updatePerPage($perPage)
    {
        $this->perPage = $perPage; // Update the items per page
    }
}
