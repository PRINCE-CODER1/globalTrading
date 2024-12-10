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

        $teams = Team::where('creator_id', $user->id)->get(); 

        $leads = Lead::with(['customer', 'leadStatus', 'leadSource', 'assignedAgent.teams'])
            ->whereIn('assigned_to', $teams->pluck('creator_id'))  // Only leads assigned to the manager's teams
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
                })
                ->orWhere('reference_id', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        // Fetch recent lead logs for the manager's team members
        $leadLogs = LeadLog::with(['lead', 'fromUser', 'toUser'])
            ->whereIn('id_from', $teams->pluck('creator_id'))
            ->orWhereIn('id_to', $teams->pluck('creator_id'))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get all lead statuses for filtering
        $statuses = LeadStatus::all();

        // Count open leads (new + in progress) for the manager's teams
        $openLeads = Lead::whereIn('assigned_to', $teams->pluck('creator_id'))
            ->whereIn('lead_status_id', function ($query) {
                $query->select('id')
                    ->from('lead_statuses')
                    ->whereIn('name', ['new', 'in progress']);
            })
            ->count();

        // Count closed leads (completed + lost) for the manager's teams
        $closedLeads = Lead::whereIn('assigned_to', $teams->pluck('creator_id'))
            ->whereIn('lead_status_id', function ($query) {
                $query->select('id')
                    ->from('lead_statuses')
                    ->whereIn('name', ['completed', 'lost']);
            })
            ->count();

        // Get leads created per day for the past month (for chart purposes)
        $leadsPerDay = Lead::select(\DB::raw('DATE(created_at) as date'), \DB::raw('count(*) as count'))
            ->whereIn('assigned_to', $teams->pluck('creator_id'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('livewire.crm.manager-dashboard', compact(
            'leadsPerDay', 'openLeads', 'closedLeads', 'leads', 
            'leadLogs', 'teams', 'statuses'
        ));
    }

    public function updatePerPage($perPage)
    {
        $this->perPage = $perPage; 
    }
}
