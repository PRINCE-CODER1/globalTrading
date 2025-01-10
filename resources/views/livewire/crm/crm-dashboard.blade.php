<div>

    <div class="container my-5">
        {{-- <h1 class="fw-bold">CRM <span class="text-secondary">Dashboard</span></h1> --}}
        <h1>CRM Dashboard</h1>
        <hr>

    </div>

    <div class="container">
        <!-- Statistics Overview -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card custom-card card-bg-white text-fixed-white">
                    <div class="card-body">
                        <div class="d-flex align-items-top mb-2">
                            <div class="flex-fill">
                                <p class="mb-0 op-7">Total Leads</p>
                            </div>
                            <div class="ms-2">
                                <span class="avatar avatar-md bg-primary shadow-sm fs-18">
                                    <i class="bi bi-person-square"></i>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 fw-medium">{{ $leads->total() }}</span>
                        <span class="fs-12 op-7 ms-1">
                            <i
                                class="ti ti-trending-{{ $percentageChange >= 0 ? 'up' : 'down' }} me-1 d-inline-block"></i>
                            {{ number_format(abs($percentageChange), 1) }}%
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card custom-card card-bg-white text-fixed-white">
                    <div class="card-body">
                        <div class="d-flex align-items-top mb-2">
                            <div class="flex-fill">
                                <p class="mb-0 op-7">Leads This Month</p>
                            </div>
                            <div class="ms-2">
                                <span class="avatar avatar-md bg-info shadow-sm fs-18">
                                    <i class="ri-calendar-2-line"></i>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 fw-medium">{{ $currentLeads }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card custom-card card-bg-white text-fixed-white">
                    <div class="card-body">
                        <div class="d-flex align-items-top mb-2">
                            <div class="flex-fill">
                                <p class="mb-0 op-7">Open Leads</p>
                            </div>
                            <div class="ms-2">
                                <span class="avatar avatar-md bg-warning shadow-sm fs-18">
                                    <i class="bi bi-check-square"></i>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 fw-medium">{{ $openLeads }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card custom-card card-bg-white text-fixed-white">
                    <div class="card-body">
                        <div class="d-flex align-items-top mb-2">
                            <div class="flex-fill">
                                <p class="mb-0 op-7">Closed Leads</p>
                            </div>
                            <div class="ms-2">
                                <span class="avatar avatar-md bg-secondary shadow-sm fs-18">
                                    <i class="bi bi-x-square"></i>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 fw-medium">{{ $closedLeads }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card custom-card card-bg-danger text-fixed-white">
                    <div class="card-body">
                        <div class="d-flex align-items-top mb-2">
                            <div class="flex-fill">
                                <p class="mb-0 op-7">Lost Leads</p>
                            </div>
                            <div class="ms-2">
                                <span class="avatar avatar-md bg-white shadow-sm fs-18">
                                    <i class="text-dark bi bi-x-square"></i>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 fw-medium">{{ $lostLeads }}</span>
                    </div>
                </div>
            </div>  
            <div class="col-md-3">
                <div class="card custom-card card-bg-white text-fixed-white">
                    <div class="card-body">
                        <div class="d-flex align-items-top mb-2">
                            <div class="flex-fill">
                                <p class="mb-0 op-7">Percentage Change</p>
                            </div>
                            <div class="ms-2">
                                <span class="avatar avatar-md bg-dark shadow-sm fs-18">
                                    <i class="bi bi-check-square "></i>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 fw-medium">{{ number_format($percentageChange, 2) }}%</span>
                        <span class="fs-12 op-7 ms-1">
                            <i
                                class="ti ti-trending-{{ $percentageChange >= 0 ? 'up' : 'down' }} me-1 d-inline-block"></i>
                            {{ number_format(abs($percentageChange), 1) }}%
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card custom-card card-bg-white text-fixed-white">
                    <div class="card-body">
                        <div class="d-flex align-items-top mb-2">
                            <div class="flex-fill">
                                <p class="mb-0 op-7">Total Teams</p>
                            </div>
                            <div class="ms-2">
                                <span class="avatar avatar-md bg-dark shadow-sm fs-18">
                                    <i class="ri-equal-line"></i>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 fw-medium">{{ $totalTeams }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Make your <span class="text-secondary">Lead</span> here</h5>
                            <a href="{{ route('leads.create') }}" class="btn btn-secondary"><i
                                class="ri-add-circle-line"></i>
                                Create Lead
                            </a>
                        </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-4">
            <!-- Agents Table -->
            <div class="col-xl-6">
                <div class="card custom-card">
                    <div class="card-header">
                        <h3 class="fw-bold">Agents</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th class="fw-bold">Name</th>
                                        <th class="fw-bold">Email</th>
                                        <th class="fw-bold">Total Leads</th>
                                        <th class="fw-bold">Team</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        @if ($user->hasRole('Agent'))
                                            <tr>
                                                <td>
                                                    <a href="{{ route('lead.agent', $user->id) }}"
                                                        class="text-decoration-none text-dark">
                                                        {{ $user->name }}
                                                    </a>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <!-- Count leads assigned to or created by the admin -->
                                                    {{ $user->leads()
                                                        ->where('assigned_to', $user->id)
                                                        ->orWhereHas('assignedAgent', function($query) use ($user) {
                                                            $query->where('id', $user->id);
                                                        })
                                                        ->count() }}
                                                </td>
                                                <td>
                                                    @php
                                                        $teamname = $user->teams->pluck('name');
                                                    @endphp
                                                    <div class="team-container">
                                                        @foreach ($teamname as $index => $team)
                                                            <span class="badge bg-dark">
                                                                {{ $team }}
                                                            </span>
                                                            @if (($index + 1) % 5 == 0 && !$loop->last)
                                                                <br>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Managers Table -->
            <div class="col-xl-6">
                <div class="card custom-card">
                    <div class="card-header">
                        <h3 class="fw-bold">Managers</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th class="fw-bold">Name</th>
                                        <th class="fw-bold">Email</th>
                                        <th class="fw-bold">Total Teams</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        @if ($user->hasRole('Manager') )
                                            <tr>
                                                <td>
                                                    <a href="{{ route('managers.leads', $user->id) }}"
                                                        class="text-decoration-none text-dark">
                                                        {{ $user->name }}
                                                    </a>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @php
                                                    // Find the team count for the current user
                                                    $teamCount = $teamsCountByUser->firstWhere('creator_id', $user->id);
                                                    @endphp
                                                    {{-- If no teams found for the user, display 0 --}}
                                                    {{ $teamCount ? $teamCount->count : 0 }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Admin Table -->
            <div class="col-xl-6">
                <div class="card custom-card">
                    <div class="card-header">
                        <h3 class="fw-bold">Admin</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th class="fw-bold">Name</th>
                                        <th class="fw-bold">Email</th>
                                        <th class="fw-bold">Total Leads</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        @if ($user->hasRole('Admin'))
                                            <tr>
                                                <td>
                                                    <a href="{{ route('lead.agent', $user->id) }}" class="text-decoration-none text-dark">
                                                        {{ $user->name }}
                                                    </a>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <!-- Count leads assigned to or created by the admin -->
                                                    {{ $user->leads()
                                                        ->where('assigned_to', $user->id)
                                                        ->orWhereHas('assignedAgent', function($query) use ($user) {
                                                            $query->where('id', $user->id);
                                                        })
                                                        ->count() }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- Leads Table Section -->
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-3">
                    <h3 class="fw-bold">Recent <span class="text-secondary">Leads</span></h3>
                    <hr>
                </div>
            </div>
        </div>
        <!-- Lead Filters Section -->
        <div class="container my-4">
            <div class="card shadow-sm rounded bg-secondary">
                <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
                    <div class="d-flex flex-wrap align-items-center justify-content-start gap-3">
                        <!-- Status Filter -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark dropdown-toggle fw-bold" data-bs-toggle="dropdown" aria-expanded="false">
                                Filter: {{ $statusFilter ?: 'All' }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" wire:click="$set('statusFilter', '')">All</a></li>
                                @foreach ($statuses as $status)
                                    <li>
                                        <a class="dropdown-item" wire:click="$set('statusFilter', '{{ $status->name }}')">
                                            {{ $status->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
    
                        <!-- Team Filter -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark btn-wave dropdown-toggle fw-bold" data-bs-toggle="dropdown" aria-expanded="false">
                                Teams: {{ $teamFilter ?: 'All' }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" wire:click="$set('teamFilter', '')">All</a></li>
                                @foreach ($teams as $team)
                                    <li>
                                        <a class="dropdown-item" wire:click="$set('teamFilter', '{{ $team->name }}')">
                                            {{ $team->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
    
                        <!-- Per Page Filter -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark btn-wave dropdown-toggle fw-bold" data-bs-toggle="dropdown" aria-expanded="false">
                                Per Page: {{ $perPage }}
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ([2, 5, 10, 20] as $size)
                                    <li>
                                        <a class="dropdown-item" href="#" wire:click.prevent="updatePerPage({{ $size }})">
                                            {{ $size }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                   <!-- Export Lead -->
                    <div class="d-flex justify-content-between gap-3 mb-1 position-relative align-items-center">
                        <!-- Export as Excel -->
                        <button 
                            wire:click="exportLeads('xlsx')" 
                            wire:loading.attr="disabled" 
                            class="btn btn-dark btn-wave fw-bold d-flex align-items-center">
                            <i class="ri-file-excel-2-line me-1"></i> Export as Excel
                        </button>
                        
                        <!-- Export as CSV -->
                        <button 
                            wire:click="exportLeads('csv')" 
                            wire:loading.attr="disabled" 
                            class="btn btn-dark btn-wave fw-bold d-flex align-items-center">
                            <i class="ri-export-line me-1"></i> Export as CSV
                        </button>
                        
                        <!-- Loading Spinner -->
                        <div wire:loading class="spinner-border text-dark ms-2" role="status" style="width: 1.5rem; height: 1.5rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
    
    
    
                    {{-- Search and Filters Row --}}
                    <div class="col-md-12 mt-3">
                        <div class=" d-flex align-items-center justify-content-between">
                            <div class="d-flex gap-3 ">
                                <!-- Search Input -->
                                <div>
                                    <input wire:model.live="search" type="text" id="search" class="form-control fw-bold" placeholder="Search">
                                </div>
                                <!-- Date Filters -->
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <label for="" class="text-white fw-bold">Start</label>
                                    <input wire:model.live="startDate" type="date" class="form-control fw-bold">
                                </div>
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <label for="" class="text-white fw-bold">End</label>
                                    <input wire:model.live="endDate" type="date" class="form-control fw-bold">
                                </div>
                            </div>
                            {{-- Reset Filters --}}
                            <div class="d-flex justify-content-end">
                                <button wire:click="resetFilters" class="btn btn-danger fw-bold">
                                    <i class="bi bi-arrow-clockwise"></i> Reset Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
           
        <div class="container mb-5">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap shadow-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="fw-bold">Action</th>
                                            <th class="fw-bold">Reference Id</th>
                                            <th class="fw-bold">Customer</th>
                                            <th class="fw-bold">Status</th>
                                            <th class="fw-bold">Assigned Agent</th>
                                            <th class="fw-bold">Expected Month</th>
                                            <th class="fw-bold">Next Follow Up Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($leads as $lead)
                                            <tr>
                                                <td><a class="btn btn-sm btn-info"
                                                        href="{{ route('leads.edit', $lead->id) }}"><i
                                                            class="ri-eye-2-line"></i></a>
                                                    <button class="btn btn-link text-danger fs-14 lh-1 p-0"
                                                        data-bs-toggle="modal" data-bs-target="#deleteSegmentModal"
                                                        wire:click="confirmDelete({{ $lead->id }})">
                                                        <i class="ri-delete-bin-5-line"></i>
                                                    </button>
                                                    <!-- Delete Modal -->
                                                    <div wire:ignore.self class="modal fade" data-bs-dismiss="modal"
                                                        id="deleteSegmentModal" tabindex="-1"
                                                        aria-labelledby="deleteSegmentModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteSegmentModalLabel">Delete</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <form wire:submit.prevent="deleteConfirmed">
                                                                    <div class="modal-body">
                                                                        <h6>Are you sure you want to delete this Lead?
                                                                        </h6>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Delete</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        
                                                </td>
                                                <td>{{ $lead->reference_id }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit($lead->customer->name, 10) }}</td>
                                                <td>
                                                    <span class="badge"
                                                    style="background-color: {{ $lead->leadStatus->color }}; color: #fff;">
                                                    {{ $lead->leadStatus->name ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>{{ $lead->assignedAgent->name  }}</td>
                                                <td>{{ $lead->expected_date }}</td>
                                                <td>{{ $lead->remarks->last()?->date ?? 'N/A' }}</td>
                                                
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="10" class="text-center">
                                                    <p class="mb-0">No records found</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination Links -->
                            <div class="mt-3">
                                {{ $leads->links('custom-pagination-links') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3 class="fw-bold">Leads Created Per Day <span class="text-secondary">(Last 30 Days)</span></h3>
                <hr>
                <div class="d-flex justify-content-center align-items-center" style="height: 400px">
                    <canvas id="leadsChart"  style="height: 100%"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="fw-bold">Lead Status <span class="text-secondary">Distribution</span></h3>
                <hr>
                <div class="d-flex justify-content-center align-items-center" style="max-height: 400px">
                    {{-- <canvas id="leadStatusCh" style="height: 100%"></canvas> --}}
                    <canvas id="leadStatusChart" style="height:100%;"></canvas>

                </div>   
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3">
                <h3 class="fw-bold">Recent <span class="text-secondary">Logs</span></h3>
                <hr>
            </div>
        </div>
        <div class="row">
            @if ($remarks->isEmpty())
                <p>No remarks found.</p>
            @else
                <div class="table-responsive ">
                    <table class="table table-bordered text-nowrap shadow-sm">
                        <thead>
                            <tr>
                                <th class="fw-bold">Remark</th>
                                <th class="fw-bold">User</th>
                                <th class="fw-bold">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($remarks as $remark)
                                <tr>
                                    <td>{{ $remark->remark }}</td>
                                    <td>{{ $remark->user->name }}</td>
                                    <td>{{ $remark->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <div class="container mb-5">
        <div class="row">
            <!-- Lead Activity Section -->
            <div class="col-md-7">
                <div class="mt-5">
                    <h4 class="mb-4 fw-bold">Leads Created</h4>
                    <hr>
                </div>
                <div class="card shadow">
                    <div class=" bg-secondary  d-flex justify-content-between align-items-center  p-3">
                        <h5 class="mb-0 text-white">Lead Log</h5>
                        <a href="{{ route('leads.index') }}" class="btn btn-sm btn-dark">Back to Leads</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="fw-bold">Lead ID</th>
                                        <th class="fw-bold">Performed By</th>
                                        <th class="fw-bold">Performed On</th>
                                        <th class="fw-bold">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($leadLogs as $log)
                                        <tr>
                                            <td>{{ $log->lead->reference_id ?? 'N/A' }}</td>
                                            
                                            <td>
                                                {{ $log->fromUser->name ?? 'System' }}
                                            </td>
                                            <td>
                                                {{ $log->created_at->format('d M Y, h:i A') }}
                                            </td>
                                            <td>
                                                {!! $log->details !!}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No logs available for this lead.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="mt-5" >
                    <h4 class="mb-4 fw-bold">Lead Creation Graph</h4>
                    <hr>
                    <div class="d-flex justify-content-center" style="max-height: 400px">
                        <canvas id="leadCreationChart" style="height:100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const leadsData = @json($leadsPerDay); // Use the variable passed from the controller

            const labels = leadsData.map(data => data.date);
            const counts = leadsData.map(data => data.count);

            const ctx = document.getElementById('leadsChart').getContext('2d');
            const leadsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Leads Created',
                        data: counts,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        },
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date',
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Number of Leads',
                            },
                            beginAtZero: true,
                        }
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

        // Lead Creation Graph (Bar chart)
        var ctx2 = document.getElementById('leadCreationChart').getContext('2d');
        var leadCreationData = @json($leadCreationData);
        var months = Object.keys(leadCreationData).map(month => {
            return new Date(0, month - 1).toLocaleString('en-US', { month: 'short' });
        });
        var leadCounts = Object.values(leadCreationData);

        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Leads Created',
                    data: leadCounts,
                    backgroundColor: '#45d65b',
                    borderColor: '#45d65b',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' leads';
                            }
                        }
                    }
                },
                scales: {
                    x: { beginAtZero: true },
                    y: { beginAtZero: true }
                }
            }
        });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var ctx = document.getElementById('leadStatusChart').getContext('2d');
            
            // Lead counts passed from the controller
            var openLeads = @json($openLeads);
            var closedLeads = @json($closedLeads);
            var lostLeads = @json($lostLeads);
    
            var leadStatusChart = new Chart(ctx, {
                type: 'pie', // Pie chart type
                data: {
                    labels: ['Open Leads', 'Closed Leads', 'Lost Leads'],
                    datasets: [{
                        label: 'Lead Statuses',
                        data: [openLeads, closedLeads, lostLeads],
                        backgroundColor: ['#45D65B', '#F39C12', '#E74C3C'], // Colors for each section
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw + ' leads';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    
</div>
