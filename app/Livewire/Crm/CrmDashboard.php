<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use App\Models\Lead;
use App\Models\LeadLog;
use App\Models\Team;
use App\Models\LeadStatus;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class CrmDashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $teamFilter = '';
    public $sortBy = 'created_at';
    public $sortDir = 'desc';
    public $perPage = 10;

    public function render()
    {
        // Fetch all teams (Admins can see all)
        $teams = Team::with('members')->get();
        $teamMemberIds = $teams->pluck('members.*.id')->flatten()->toArray();

        // Total leads for all agents in the system (global view)
        $totalLeads = Lead::count();

        // Total leads created in the current month (Admin-level statistics)
        $currentLeads = Lead::whereBetween('created_at', [now()->startOfMonth(), now()])->count();

        // Leads from the previous month for comparison
        $previousLeads = Lead::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count();

        // Calculate the percentage change in leads between the current and previous month
        $percentageChange = $previousLeads > 0 ? (($currentLeads - $previousLeads) / $previousLeads) * 100 : 0;

        // Fetch all leads (for admins, this shows all leads)
        $leads = Lead::with(['customer', 'leadStatus', 'leadSource', 'assignedAgent.teams'])
            ->when($this->teamFilter, function($query) {
                $query->whereHas('assignedAgent.teams', function ($q) {
                    $q->where('name', 'like', '%' . $this->teamFilter . '%');
                });
            })
            ->when($this->statusFilter, function($query) {
                $query->whereHas('leadStatus', function ($q) {
                    $q->where('name', $this->statusFilter);
                });
            })
            ->where(function($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        // Fetch recent lead logs for all agents
        $leadLogs = LeadLog::with(['lead', 'fromUser', 'toUser'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Fetch all lead statuses for filtering
        $statuses = LeadStatus::all();

        // Count open leads (new + in progress) globally
        $openLeads = Lead::whereIn('lead_status_id', function ($query) {
            $query->select('id')
                ->from('lead_statuses')
                ->whereIn('name', ['new', 'in progress']);
        })->count();

        // Count closed leads (completed + lost) globally
        $closedLeads = Lead::whereIn('lead_status_id', function ($query) {
            $query->select('id')
                ->from('lead_statuses')
                ->whereIn('name', ['completed', 'lost']);
        })->count();

        // Leads created per day globally for charting
        $leadsPerDay = Lead::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

            $leadStatusCounts = Lead::select('lead_status_id', DB::raw('count(*) as count'))
            ->groupBy('lead_status_id')
            ->pluck('count', 'lead_status_id');
        $users = User::with(['leads', 'teams'])->get();
        return view('livewire.crm.crm-dashboard', compact(
            'leadsPerDay', 'openLeads', 'closedLeads', 'leads','users', 
            'leadLogs', 'teams','leadStatusCounts', 'statuses', 'totalLeads', 
            'currentLeads', 'percentageChange'
        ));
    }

    public function updatePerPage($perPage)
    {
        $this->perPage = $perPage; // Update the items per page
    }
}
