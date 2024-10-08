<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use App\Models\Lead;
use App\Models\LeadLog;
use App\Models\Team;
use App\Models\LeadStatus;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class ManagerDashboard extends Component
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
        $user = Auth::user();  // Get the currently logged-in manager

        // Fetch all teams managed by the current manager
        $teams = Team::where('creator_id', $user->id)->with('members')->get();
        $teamMemberIds = $teams->pluck('members.*.id')->flatten()->toArray(); // Get IDs of all team members

        // Total leads for the current period (for the manager's team members)
        $currentLeads = Lead::whereIn('assigned_to', $teamMemberIds)->count(); 

        // Total leads for the previous period (last month)
        $previousLeads = Lead::whereIn('assigned_to', $teamMemberIds)
            ->whereBetween('created_at', [now()->subMonth(), now()])
            ->count();

        // Calculate percentage change in leads between current and previous period
        $percentageChange = $previousLeads > 0 ? (($currentLeads - $previousLeads) / $previousLeads) * 100 : 0;

        // Fetch all leads assigned to the team members
        $leads = Lead::with(['customer', 'leadStatus', 'leadSource', 'assignedAgent.teams'])
            ->whereIn('assigned_to', $teamMemberIds)  // Only leads assigned to the manager's team members
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

        // Fetch recent lead logs for the team members
        $leadLogs = LeadLog::with(['lead', 'fromUser', 'toUser'])
            ->whereIn('id_from', $teamMemberIds)
            ->orWhereIn('id_to', $teamMemberIds)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get all lead statuses for filtering
        $statuses = LeadStatus::all();

        // Count open leads (new + in progress) for the manager's team members
        $openLeads = Lead::whereIn('assigned_to', $teamMemberIds)
            ->whereIn('lead_status_id', function ($query) {
                $query->select('id')
                    ->from('lead_statuses')
                    ->whereIn('name', ['new', 'in progress']);
            })
            ->count();

        // Count closed leads (completed + lost) for the manager's team members
        $closedLeads = Lead::whereIn('assigned_to', $teamMemberIds)
            ->whereIn('lead_status_id', function ($query) {
                $query->select('id')
                    ->from('lead_statuses')
                    ->whereIn('name', ['completed', 'lost']);
            })
            ->count();

        // Get leads created per day for the past month (for chart purposes)
        $leadsPerDay = Lead::select(\DB::raw('DATE(created_at) as date'), \DB::raw('count(*) as count'))
            ->whereIn('assigned_to', $teamMemberIds)
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('livewire.crm.manager-dashboard', compact(
            'leadsPerDay', 'openLeads', 'closedLeads', 'leads', 
            'leadLogs', 'teams', 'statuses', 'percentageChange'
        ));
    }

    public function updatePerPage($perPage)
    {
        $this->perPage = $perPage; 
    }
}
