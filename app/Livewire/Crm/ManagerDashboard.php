<?php

namespace App\Livewire\Crm;

use Livewire\Component;
use App\Models\Lead;
use App\Models\LeadLog;
use App\Models\User;
use App\Models\Team;
use App\Models\Remark;
use App\Models\LeadStatus;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeadsExport;

class ManagerDashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $teamFilter = '';
    public $sortBy = 'created_at';
    public $sortDir = 'desc';
    public $perPage = 10;
    public $leadIdToDelete = null;
    public $startDate;
    public $endDate;

    protected function logLeadAction($lead, $logType, $details)
    {
        if ($lead) {
            LeadLog::create([
                'lead_id' => $lead->id,
                'id_from' => auth()->id(),
                'id_to' => $lead->assigned_to ?? null,
                'log_type' => $logType,
                'details' => $details,
            ]);
        } else {
            toastr()->error("Lead does not exist.");
        }
    }

    public function exportLeads($type = 'xlsx')
    {
        $filteredLeads = Lead::with(['customer', 'leadStatus', 'assignedAgent'])
            ->whereIn('assigned_to', Team::where('creator_id', auth()->id())->pluck('creator_id'))
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
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->where(function ($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere('reference_id', 'like', '%' . $this->search . '%');
            })
            ->get();

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
        $user = Auth::user();  

        $teams = Team::where('creator_id', $user->id)->get();
        $assignedToIds = $teams->pluck('creator_id')->push($user->id);
        // Fetch leads assigned to the manager's teams
        $leads = Lead::with(['customer', 'leadStatus', 'leadSource', 'assignedAgent.teams'])
            ->whereIn('assigned_to',$assignedToIds)  // Only leads assigned to the manager's teams
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
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
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
        $leadLogs = LeadLog::with(['lead' => function ($query) {
            $query->withTrashed();
        }, 'fromUser', 'toUser'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get all lead statuses for filtering
        $statuses = LeadStatus::all();

        // Count open leads (statuses belonging to the 'open' category) for the manager's teams
        $openLeads = Lead::whereIn('assigned_to', $teams->pluck('creator_id'))
            ->whereIn('lead_status_id', function ($query) {
                $query->select('id')
                    ->from('lead_statuses')
                    ->where('category', 'open');
            })
            ->count();

        // Count closed leads (statuses belonging to the 'closed' or 'completed' categories) for the manager's teams
        $closedLeads = Lead::whereIn('assigned_to', $teams->pluck('creator_id'))
            ->whereIn('lead_status_id', function ($query) {
                $query->select('id')
                    ->from('lead_statuses')
                    ->whereIn('category', ['closed', 'completed']);
            })
            ->count();


        // Count lost leads (statuses belonging to the 'lost' category) for the manager's teams
        $lostLeads = Lead::whereIn('assigned_to', $teams->pluck('creator_id'))
            ->whereIn('lead_status_id', function ($query) {
                $query->select('id')
                    ->from('lead_statuses')
                    ->where('category', 'lost');
            })
            ->count();

        $currentLeads = Lead::whereIn('assigned_to', $teams->pluck('creator_id'))
            ->whereBetween('created_at', [now()->startOfMonth(), now()])
            ->count();


        // Get leads created per day for the past month (for chart purposes)
        $leadsPerDay = Lead::select(\DB::raw('DATE(created_at) as date'), \DB::raw('count(*) as count'))
            ->whereIn('assigned_to', $teams->pluck('creator_id'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
            
            $leadsAssignedPerDay = Lead::select(
                \DB::raw('DATE(created_at) as date'),
                \DB::raw('count(*) as count')
            )
            ->whereIn('assigned_to', $teams->pluck('creator_id'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        // Fetch recent remarks
        $remarks = Remark::with('user', 'lead')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $users = User::with(['leads', 'teams'])->get();

        return view('livewire.crm.manager-dashboard', compact(
            'leadsPerDay', 'openLeads', 'closedLeads','lostLeads','currentLeads', 'leads','users', 
            'leadLogs', 'teams', 'statuses','leadsAssignedPerDay','remarks'
        ));
    }
    public function resetFilters()
    {
        $this->search = '';
        $this->teamFilter = null;
        $this->statusFilter = null;
        $this->startDate = null;
        $this->endDate = null;
    }
    public function confirmDelete($id)
    {
        $this->leadIdToDelete = $id;
    }

    public function deleteConfirmed()
    {
        if ($this->leadIdToDelete) {
            $lead = Lead::find($this->leadIdToDelete);
            if ($lead) {
                // Log the action before deleting the lead
                $this->logLeadAction(
                    $lead,
                    'lead_deleted',
                    "<strong class='text-danger'>Lead with ID {$lead->id} and customer {$lead->Customer->name} was deleted by </strong> " . auth()->user()->name
                );

                // Now delete the lead
                $lead->delete();
                toastr()->closeButton(true)->success('Lead Deleted Successfully');
            } else {
                toastr()->error('Lead not found.');
            }
            $this->leadIdToDelete = null;
        }

        $this->resetPage();
    }


    public function updatePerPage($perPage)
    {
        $this->perPage = $perPage; 
    }
}
