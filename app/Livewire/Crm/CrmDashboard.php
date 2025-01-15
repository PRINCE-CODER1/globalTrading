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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeadsExport;



class CrmDashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $teamFilter = '';
    public $sortBy = 'created_at';
    public $leadIdToDelete;
    public $sortDir = 'desc';
    public $perPage = 10;
    public $startDate;
    public $endDate;

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
    protected function logLeadAction($lead, $logType, $details)
    {
        // Check if the lead exists before inserting the log
        if ($lead) {
            \App\Models\LeadLog::create([
                'lead_id' => $lead->id,
                'id_from' => auth()->id(),
                'id_to' => $lead->assigned_to ?? null,
                'log_type' => $logType,
                'details' => $details,
            ]);
        } else {
            toastr()->error("Lead with ID {$lead->id} does not exist.");
        }
    }

    public function exportLeads($type = 'xlsx')
    {
        $user = Auth::user();

        // Get all filtered leads
        $filteredLeads = $this->filteredQuery($user)->get();

        $date = now()->format('Y_m_d');

        if ($type === 'xlsx') {
            return Excel::download(new LeadsExport($filteredLeads), "lead_report_{$date}.xlsx");
        } elseif ($type === 'csv') {
            return Excel::download(new LeadsExport($filteredLeads), "lead_report_{$date}.csv");
        } else {
            return redirect()->back()->with('error', 'Invalid file type selected.');
        }
    }


    public function render()
    {

        $teams = Team::all();
        $teamsCountByUser = Team::select('creator_id', DB::raw('count(*) as count'))
            ->groupBy('creator_id')
            ->get();
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

        $user = Auth::user();
        // Fetch leads with filters and search
        $leads = $this->filteredQuery($user)->paginate($this->perPage);


        // Recent lead logs
        $leadLogs = LeadLog::with(['lead' => function ($query) {
            $query->withTrashed();
        }, 'fromUser', 'toUser'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Lead status filtering options
        $statuses = LeadStatus::all();

        // Count open leads globally (new + in progress)
        $openLeads = Lead::whereIn('lead_status_id', LeadStatus::where('category', 'open')->pluck('id'))->count();

        // Count closed leads globally (completed + lost)
        $closedLeads = Lead::whereIn('lead_status_id', LeadStatus::whereIn('category', ['closed', 'completed'])->pluck('id'))->count();

        // Count lost leads globally (lost)
        $lostLeads = Lead::whereIn('lead_status_id', LeadStatus::where('category', 'lost')->pluck('id'))->count();

        $leadCreationData = Lead::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupByRaw('MONTH(created_at)')
        ->orderBy('month')
        ->get()
        ->pluck('total', 'month');

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

        return view('livewire.crm.crm-dashboard', compact('teams','totalTeams','teamsCountByUser',
            'leadsPerDay', 'openLeads', 'closedLeads','lostLeads','leadCreationData', 'leads', 'users', 
            'leadLogs', 'statuses', 'totalLeads', 'currentLeads', 
            'percentageChange', 'remarks', 'leadStatusCounts'
        ));
    }
    protected function filteredQuery($user)
    {
        return Lead::with(['customer', 'leadStatus', 'leadSource', 'assignedAgent.teams'])
            ->where('assigned_to', $user->id) // Always restrict to the authenticated user's leads
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
                })->orWhere('reference_id', 'like', '%' . $this->search . '%');
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->orderBy($this->sortBy, $this->sortDir);
    }


    public function resetFilters()
    {
        $this->search = '';
        $this->teamFilter = null;
        $this->statusFilter = null;
        $this->startDate = null;
        $this->endDate = null;
    }
    
    public function updatePerPage($perPage)
    {
        $this->perPage = $perPage;
    }
    public function confirmDelete($id)
    {
        $this->leadIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->leadIdToDelete) {
            // Find the lead before deletion
            $lead = Lead::find($this->leadIdToDelete);

            if ($lead) {
                // Log the lead deletion
                $this->logLeadAction(
                    $lead,
                    'lead_deleted',
                    "<strong class='text-danger'>Lead with ID {$lead->id} and customer {$lead->Customer->name} was deleted by </strong>" . auth()->user()->name
                );
    

                // Delete the lead
                $lead->delete();

                toastr()->closeButton(true)->success('Lead Deleted Successfully');
            } else {
                toastr()->error('Lead not found or already deleted.');
            }

            $this->leadIdToDelete = null;
        }

        $this->resetPage();
    }


    public function bulkDelete()
    {
        if (!empty($this->selectedLeads)) {
            // Fetch all selected leads
            $leads = Lead::whereIn('id', $this->selectedLeads)->get();

            foreach ($leads as $lead) {
                // Log the lead deletion for each lead
                $this->logLeadAction(
                    $lead,
                    'lead_deleted',
                    "<strong class='text-danger'>Lead with ID {$lead->id} and customer {$lead->Customer->name} was deleted by </strong>" . auth()->user()->name
                );
    

                // Delete the lead
                $lead->delete();
            }

            // Clear selected leads
            $this->selectedLeads = [];

            toastr()->closeButton(true)->success('Selected Leads Deleted Successfully');
        } else {
            toastr()->warning('No leads selected for deletion.');
        }

        $this->resetPage();
    }

}
