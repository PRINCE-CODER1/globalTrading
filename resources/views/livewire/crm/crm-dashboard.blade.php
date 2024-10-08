<div>
    
    <div class="container my-5">
        <h1 class="fw-bold">CRM <span class="text-secondary">Dashboard</span></h1>
        <hr>
        <hr>
    </div>

    <div class="container">
        <!-- Statistics Overview -->
        <div class="row mb-4">
            <div class="col-md-6">
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
                      <span class="fs-12 op-7 ms-1">
                        <i class="ti ti-trending-{{ $percentageChange >= 0 ? 'up' : 'down' }} me-1 d-inline-block"></i>
                        {{ number_format(abs($percentageChange), 1) }}%
                    </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card custom-card card-bg-white text-fixed-white">
                    <div class="card-body">
                        <div class="d-flex align-items-top mb-2">
                            <div class="flex-fill">
                                <p class="mb-0 op-7">Leads This Month</p>
                            </div>
                            <div class="ms-2">
                                <span class="avatar avatar-md bg-secondary shadow-sm fs-18">
                                    <i class="ri-calendar-2-line"></i>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 fw-medium">{{ $currentLeads }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
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
            <div class="col-md-6">
                <div class="card custom-card card-bg-danger text-fixed-white">
                    <div class="card-body">
                        <div class="d-flex align-items-top mb-2">
                            <div class="flex-fill">
                                <p class="mb-0 op-7">Closed Leads</p>
                            </div>
                            <div class="ms-2">
                                <span class="avatar avatar-md bg-dark shadow-sm fs-18">
                                    <i class="bi bi-x-square"></i>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 fw-medium">{{ $closedLeads }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card custom-card card-bg-secondary text-fixed-white">
                    <div class="card-body">
                        <div class="d-flex align-items-top mb-2">
                            <div class="flex-fill">
                                <p class="mb-0 op-7">Percentage Change</p>
                            </div>
                            <div class="ms-2">
                                <span class="avatar avatar-md bg-white shadow-sm fs-18">
                                    <i class="bi bi-check-square text-dark"></i>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 fw-medium">{{ number_format($percentageChange, 2) }}%</span>
                        <span class="fs-12 op-7 ms-1">
                            <i class="ti ti-trending-{{ $percentageChange >= 0 ? 'up' : 'down' }} me-1 d-inline-block"></i>
                            {{ number_format(abs($percentageChange), 1) }}%
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
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
            <div class="col-md-6">
                <h3 class="fw-bold">Leads Created Per Day <span class="text-secondary">(Last 30 Days)</span></h3>
                <hr>
                <canvas id="leadsChart"></canvas>
            </div>
            <div class="col-md-6">
                <h3 class="fw-bold">Lead Status <span class="text-secondary">Distribution</span></h3>
                <hr>
                <div style="height:300px">
                   <div class="d-flex justify-content-center" style="max-height:100%">
                    <canvas  id="leadStatusCh"></canvas>
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
                                        @if ($user->role == 'Agent')
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->leads->count() }}</td>
                                                <td>
                                                    @php
                                                        $teamname = $user->teams->pluck('name');
                                                    @endphp
                                                    <div class="team-container">
                                                        @foreach ($teamname as $index => $team)
                                                            <span class="badge bg-secondary">
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
                                        <th class="fw-bold">Total Leads</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        @if ($user->role == 'Manager')
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->leads->count() }}</td>
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
        <div class="container">     
            <div class="row mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Filter: {{ $statusFilter ?: 'All' }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" wire:click="$set('statusFilter', '')">All</a></li>
                                @foreach($statuses as $status)
                                    <li><a class="dropdown-item" wire:click="$set('statusFilter', '{{ $status->name }}')">{{ $status->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Teams : {{ $teamFilter ?: 'All' }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" wire:click="$set('teamFilter', '')">All</a></li>
                                @foreach($teams as $team)
                                    <li><a class="dropdown-item" wire:click="$set('teamFilter', '{{ $team->name }}')">{{ $team->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Per Page: {{ $perPage }}
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ([2, 5, 10, 20] as $size)
                                    <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage({{ $size }})">{{ $size }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- Search Input -->
                    <div class="d-flex align-items-center">
                        <div class="col-auto">
                            <input wire:model.live="search" type="text" id="search" class="form-control" placeholder="Search">
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
                                            <th class="fw-bold">Customer</th>
                                            <th class="fw-bold">Lead Source</th>
                                            <th class="fw-bold">Assigned Agent</th>
                                            <th class="fw-bold">Team</th>
                                            <th class="fw-bold">Capture Date</th>
                                            <th class="fw-bold">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($leads as $lead)
                                            <tr>
                                                <td><a class="btn btn-sm btn-info" href="{{ route('agent.leads.edit', $lead->id) }}"><i class="ri-eye-2-line"></i> View Lead</a></td>
                                                <td>{{ $lead->customer->name }}</td>
                                                <td>{{ $lead->leadSource->name }}</td>
                                                <td>{{ $lead->assignedAgent->name }}</td>
                                                <td>
                                                    @foreach($lead->assignedAgent->teams as $index => $team)
                                                        <span class="badge bg-secondary ">{{ $team->name }}</span>
                                                        @if (($index + 1) % 3 == 0)
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                </td>  
                                                <td>{{ $lead->created_at->format('Y-m-d') }}</td>
                                                <td><span class="badge" style="background-color: {{ $lead->leadStatus->color }}; color: #fff;">{{ $lead->leadStatus->name }}</span></td>
                                            </tr>
                                        @endforeach
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
            <div class="col-12 mt-3">
                <h3 class="fw-bold">Recent <span class="text-secondary">Logs</span></h3>
                <hr>
            </div>
        </div>
        <div class="row">
            @if($remarks->isEmpty())
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
                            @foreach($remarks as $remark)
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
            <div class="col-md-5">
                <div class="mt-5">
                    <h4 class="mb-4 fw-bold">Leads Created</h4>
                    <hr>
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach($leadLogs as $log)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $log->fromUser->name }}</strong> 
                                            @if($log->id_to)
                                                <span class="text-success">reassigned lead to <strong>{{ $log->toUser->name }}</strong></span>
                                            @else
                                                <span class="text-muted">{{ str_replace('_', ' ', $log->log_type) }}</span>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ $log->created_at->format('Y-m-d H:i:s') }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mt-5" style="height:400px">
                    <h4 class="mb-4 fw-bold">Lead Creation Graph</h4>
                    <hr>
                   <div class="d-flex justify-content-center" style="height:400px">
                    <canvas  id="leadStatusChart"></canvas>
                   </div>
                </div>
            </div>  
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('leadStatusChart').getContext('2d');

            const statusCounts = @json($leadStatusCounts); // Your PHP data
            const statusNames = @json($statuses); // Your PHP data

            // Prepare data for the chart
            const dataValues = Object.values(statusCounts);
            const labels = Object.keys(statusCounts).map((statusId) => {
                const foundStatus = statusNames.find(status => status.id == statusId); // Match status ID
                return foundStatus ? foundStatus.name : statusId; // Return name if found, else return ID
            });

            // Define an array of 15 custom colors
            const customColors = [
                'rgba(76, 175, 80, 0.7)', // Green
                'rgba(244, 67, 54, 0.7)', // Red
                'rgba(255, 152, 0, 0.7)', // Orange
                'rgba(33, 150, 243, 0.7)', // Blue
                'rgba(156, 39, 176, 0.7)', // Purple
                'rgba(255, 193, 7, 0.7)', // Yellow
                'rgba(0, 150, 136, 0.7)', // Teal
                'rgba(158, 158, 158, 0.7)', // Grey
                'rgba(255, 87, 34, 0.7)', // Deep Orange
                'rgba(63, 81, 181, 0.7)', // Indigo
                'rgba(76, 175, 80, 0.7)', // Light Green
                'rgba(244, 67, 54, 0.7)', // Deep Red
                'rgba(0, 188, 212, 0.7)', // Cyan
                'rgba(121, 85, 72, 0.7)', // Brown
                'rgba(96, 125, 139, 0.7)', // Blue Grey
                'rgba(255, 235, 59, 0.7)' // Lime
            ];

            // Generate background and border colors based on the number of labels
            const backgroundColors = labels.map((_, index) => customColors[index % customColors.length]);
            const borderColors = labels.map((_, index) => customColors[index % customColors.length]);

            const leadStatusChart = new Chart(ctx, {
                type: 'pie', // Or any other type
                data: {
                    labels: labels, // This will now contain the names
                    datasets: [{
                        label: 'Lead Status',
                        data: dataValues,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        }
                    }
                }
            });
        });
    </script>

    <script>
        const ctx = document.getElementById('leadStatusCh').getContext('2d');
        const leadStatusData = {
            labels: ['Open', 'Closed', 'Follow-up', 'Lost'], // Replace with dynamic data
            datasets: [{
                label: 'Lead Status Distribution',
                data: [12, 19, 3, 5], // Replace with dynamic counts
                backgroundColor: [
                    '#4CAF50', // Green for Open
                    '#F44336', // Red for Closed
                    '#FF9800', // Orange for Follow-up
                    '#2196F3', // Blue for Lost
                ],
                borderWidth: 1
            }]
        };

        
        const leadStatusChart = new Chart(ctx, {
            type: 'pie',
            data: leadStatusData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Lead Status Distribution'
                    }
                }
            }
        });
    </script>
</div>
