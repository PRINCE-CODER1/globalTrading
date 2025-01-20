<div>
    <div class="container mt-5">
        <h1 class="fw-bold">Manager <span class="text-secondary">Dashboard</span></h1>
        <hr>
        <hr>
    
        <!-- Statistics Overview -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card custom-card card-bg-secondary text-fixed-white">
                    <div class="card-body">
                      <div class="d-flex align-items-top mb-2">
                        <div class="flex-fill">
                          <p class="mb-0 op-7">Total Leads</p>
                        </div>
                        <div class="ms-2">
                          <span class="avatar avatar-md bg-dark shadow-sm fs-18">
                            <i class="bi bi-person-square"></i>
                          </span>
                        </div>
                      </div>
                      <span class="fs-5 fw-medium">{{ $leads->total() }}</span>
                      {{-- <span class="fs-12 op-7 ms-1">
                        <i class="ti ti-trending-{{ $percentageChange >= 0 ? 'up' : 'down' }} me-1 d-inline-block"></i>
                        {{ number_format(abs($percentageChange), 1) }}%
                    </span> --}}
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
                                <span class="avatar avatar-md bg-secondary shadow-sm fs-18">
                                    <i class="bi bi-check-square"></i>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 fw-medium">{{ $openLeads }}</span>
                    </div>
                </div>
            </div>
    
            <div class="col-md-3">
                <div class="card custom-card card-bg-dark text-fixed-white">
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
                                <p class="mb-0 op-7">lost Leads</p>
                            </div>
                            <div class="ms-2">
                                <span class="avatar avatar-md bg-dark shadow-sm fs-18">
                                    <i class="bi bi-x-square"></i>
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
                                <p class="mb-0 op-7">Total Teams</p>
                            </div>
                            <div class="ms-2">
                                <span class="avatar avatar-md bg-secondary shadow-sm fs-18">
                                    <i class="ri-equal-line"></i>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 fw-medium">{{ count($teams) }}</span>
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

    <!-- Agent And Manager -->
    <div class="container">
        <div class="row">
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

    <!-- Team Performance -->
    <div class="container">
        <h4 class="fw-bold">Teams <span class="text-secondary">Overview </span></h4>
        <hr>
        <div class="row">
            @foreach($teams as $team)
            <div class="col-md-6 mb-3">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-top justify-content-between">
                            <div>
                                <span class="avatar bg-secondary-transparent svg-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="rgba(69,214,91,1)"><path d="M17.0839 15.812C19.6827 13.0691 19.6379 8.73845 16.9497 6.05025C14.2161 3.31658 9.78392 3.31658 7.05025 6.05025C4.36205 8.73845 4.31734 13.0691 6.91612 15.812C7.97763 14.1228 9.8577 13 12 13C14.1423 13 16.0224 14.1228 17.0839 15.812ZM8.38535 17.2848L12 20.8995L15.6147 17.2848C14.9725 15.9339 13.5953 15 12 15C10.4047 15 9.0275 15.9339 8.38535 17.2848ZM12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364L12 23.7279ZM12 10C12.5523 10 13 9.55228 13 9C13 8.44772 12.5523 8 12 8C11.4477 8 11 8.44772 11 9C11 9.55228 11.4477 10 12 10ZM12 12C10.3431 12 9 10.6569 9 9C9 7.34315 10.3431 6 12 6C13.6569 6 15 7.34315 15 9C15 10.6569 13.6569 12 12 12Z"></path></svg>
                                </span>
                            </div>
                            <div class="flex-fill ms-3 d-flex align-items-start justify-content-between">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <p class="text-muted mb-3">{{ $team->name }}</p>
                                        <h4 class="mt-1">Leads Assigned: {{ $team->agents->count()}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            @endforeach
        </div>
    </div>
    
    <!-- Filters Row -->
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
    <!-- Leads Table -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="fw-bold">Action</th>
                                        <th class="fw-bold">Refrence Id</th>
                                        <th class="fw-bold">Customer</th>
                                        <th class="fw-bold">Assigned Agent</th>
                                        <th class="fw-bold">Status</th>
                                        <th class="fw-bold">Series</th>
                                        <th class="fw-bold">Amount</th>
                                        <th class="fw-bold">Expected Date</th>
                                        <th class="fw-bold">Next Follow Up Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($leads as $lead)
                                        <tr>
                                            <td>
                                                <a class="btn btn-sm btn-info"
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
                                            <td>{{ $lead->customer->name }}</td>
                                            <td>{{ $lead->assignedAgent->name }}</td>
                                            <td><span class="badge" style="background-color: {{ $lead->leadStatus->color }}; color: #fff;">{{ $lead->leadStatus->name }}</span></td>
                                            <td>{{ $lead->Series->name ?? 'N/A' }}</td>
                                            <td>{{ $lead->amount ?? 'N/A' }}</td>
                                            <td>{{ $lead->expected_date ? \Carbon\Carbon::parse($lead->expected_date)->format('Y-m-d') : 'N/A' }}</td>
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
                        
                            {{ $leads->links('custom-pagination-links') }} 
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logs Section -->
    <div class="container">
        <div class="row mb-3">
            <!-- Lead Logs Section -->
            <div class="col-md-7">
                <div class="mt-5">
                    <h4 class="mb-4 fw-bold">Leads <span class="text-secondary">Activities</span></h4>
                    <hr>
                </div>
                <div class="card shadow">
                    <div class="bg-secondary d-flex justify-content-between align-items-center p-3">
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
                                            <td>{{ $log->fromUser->name ?? 'System' }}</td>
                                            <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
                                            <td>{!! $log->details !!}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No logs available for this lead.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Logs Section -->
            <div class="col-md-5">
                <div class="mt-5">
                    <h4 class="mb-4 fw-bold">Recent <span class="text-secondary">Logs</span></h4>
                    <hr>
                </div>
                <div class="card shadow">
                    <div class="bg-secondary d-flex justify-content-between align-items-center p-3">
                        <h5 class="mb-0 text-white">Recent Logs</h5>
                    </div>
                    <div class="card-body">
                        @if ($remarks->isEmpty())
                            <p class="text-center">No remarks found.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-nowrap">
                                    <thead class="bg-light">
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
                                                <td>{{ $remark->user->name ?? 'Unknown' }}</td>
                                                <td>{{ $remark->created_at->format('d M Y, h:i A') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Graph Section -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="mt-5" style="height:400px">
                    <h4 class="mb-4 fw-bold">Lead<span class="text-secondary"> Status Overview</span></h4>
                    <hr>
                   <div>
                    <canvas  id="leadsCreatedChart"></canvas>
                   </div>
                </div>
            </div>  
            <div class="col-md-6 col-sm-12">
                <div class="mt-5" style="height:400px">
                    <h4 class="mb-4 fw-bold">Leads<span class="text-secondary"> Assigned</span></h4>
                    <hr>
                   <div>
                    <canvas  id="leadsAssignedChart"></canvas>
                   </div>
                </div>
            </div>
        </div>
    </div> 
    @push('scripts')
        <!-- Include Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Data preparation for Leads Created
                const leadsCreatedData = @json($leadsPerDay);
                const createdLabels = leadsCreatedData.map(data => data.date);
                const createdCounts = leadsCreatedData.map(data => data.count);

                // Data preparation for Leads Assigned
                const leadsAssignedData = @json($leadsAssignedPerDay);
                const assignedLabels = leadsAssignedData.map(data => data.date);
                const assignedCounts = leadsAssignedData.map(data => data.count);

                // Leads Created Chart
                const createdCtx = document.getElementById('leadsCreatedChart').getContext('2d');
                const leadsCreatedChart = new Chart(createdCtx, {
                    type: 'line',
                    data: {
                        labels: createdLabels,
                        datasets: [{
                            label: 'Leads Created',
                            data: createdCounts,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: true, position: 'top' },
                            tooltip: { mode: 'index', intersect: false },
                        },
                        scales: {
                            x: { title: { display: true, text: 'Date' } },
                            y: { title: { display: true, text: 'Number of Leads' }, beginAtZero: true }
                        }
                    }
                });

                // Leads Assigned Chart
                const assignedCtx = document.getElementById('leadsAssignedChart').getContext('2d');
                const leadsAssignedChart = new Chart(assignedCtx, {
                    type: 'bar', // Use a bar chart for variety
                    data: {
                        labels: assignedLabels,
                        datasets: [{
                            label: 'Leads Assigned',
                            data: assignedCounts,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)', // Bar color
                            borderColor: 'rgba(54, 162, 235, 1)', // Border color
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: true, position: 'top' },
                            tooltip: { mode: 'index', intersect: false },
                        },
                        scales: {
                            x: { title: { display: true, text: 'Date' } },
                            y: { title: { display: true, text: 'Number of Leads' }, beginAtZero: true }
                        }
                    }
                });
            });
        </script>
    @endpush


</div>