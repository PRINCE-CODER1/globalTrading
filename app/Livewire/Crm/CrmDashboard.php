<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use App\Models\Lead;
use App\Models\LeadLog;
use App\Models\Remark;
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

    // Listen for filter changes and reset the pagination
    protected $updatesQueryString = ['search', 'statusFilter', 'teamFilter', 'sortBy', 'sortDir', 'perPage'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingTeamFilter()
    {
        $this->resetPage();
    }

    public function render()
    {

        $teams = Team::all();
        // Total teams for admin view
        $totalTeams = Team::count();

        // Total leads for global view
        $totalLeads = Lead::count();

        // Leads created this month
        $currentLeads = Lead::whereBetween('created_at', [now()->startOfMonth(), now()])->count();

        // Leads from the previous month
        $previousLeads = Lead::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count();

        // Calculate percentage change in leads
        $percentageChange = $previousLeads > 0 ? (($currentLeads - $previousLeads) / $previousLeads) * 100 : 0;

        // Fetch leads with filters and search
        $leads = Lead::with(['customer', 'leadStatus', 'leadSource', 'assignedAgent.teams'])
            ->when($this->teamFilter, function ($query) {
                $query->whereHas('assignedAgent.teams', function ($q) {
                    $q->where('name', 'like', '%' . $this->teamFilter . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->whereHas('leadStatus', function ($q) {
                    $q->where('name', $this->statusFilter);
                });
            })
            ->when($this->search, function ($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        // Recent lead logs
        $leadLogs = LeadLog::with(['lead', 'fromUser', 'toUser'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Lead status filtering options
        $statuses = LeadStatus::all();

        // Count open leads globally (new + in progress)
        $openLeads = Lead::whereIn('lead_status_id', LeadStatus::whereIn('name', ['new', 'in progress'])->pluck('id'))->count();

        // Count closed leads globally (completed + lost)
        $closedLeads = Lead::whereIn('lead_status_id', LeadStatus::whereIn('name', ['completed', 'lost'])->pluck('id'))->count();

        // Leads created per day for the last 30 days
        $leadsPerDay = Lead::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Lead status counts
        $leadStatusCounts = Lead::select('lead_status_id', DB::raw('count(*) as count'))
            ->groupBy('lead_status_id')
            ->pluck('count', 'lead_status_id');

        // Fetch users (agents)
        $users = User::with(['leads', 'teams'])->get();

        // Fetch recent remarks
        $remarks = Remark::with('user', 'lead')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('livewire.crm.crm-dashboard', compact('teams','totalTeams',
            'leadsPerDay', 'openLeads', 'closedLeads', 'leads', 'users', 
            'leadLogs', 'statuses', 'totalLeads', 'currentLeads', 
            'percentageChange', 'remarks', 'leadStatusCounts'
        ));
    }

    public function updatePerPage($perPage)
    {
        $this->perPage = $perPage;
    }
}
