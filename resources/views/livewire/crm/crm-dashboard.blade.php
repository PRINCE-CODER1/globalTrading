<div>
    
    <div class="container my-5">
        <h1 class="fw-bold">Admin <span class="text-secondary">Dashboard</span></h1>
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

    <div class="container mb-5">
        <div class="row">
            <!-- Recent Lead Activity Section -->
            <div class="col-md-5">
                <div class="mt-5">
                    <h4 class="mb-4 fw-bold">Recent Activity Logs</h4>
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
                    <h4 class="mb-4 fw-bold">Lead Status Overview</h4>
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

            const backgroundColors = labels.map(() => getRandomColor());
            const borderColors = labels.map(() => getRandomColor());

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

        // Function to generate random color
        function getRandomColor() {
            // Generate random values for RGB channels (0-255)
            const r = Math.floor(Math.random() * 256); // Red
            const g = Math.floor(Math.random() * 256); // Green
            const b = Math.floor(Math.random() * 256); // Blue
            const a = (Math.random()).toFixed(2); // Alpha (0 to 1)

            // Return the RGBA color string
            return `rgba(${r}, ${g}, ${b}, ${a})`;
        }
    </script>
<script>
    const ctx = document.getElementById('leadStatusCh').getContext('2d');
    const leadStatusData = {
        labels: ['Open', 'Closed', 'Follow-up', 'Lost'], // Replace with dynamic data
        datasets: [{
            label: 'Lead Status Distribution',
            data: [12, 19, 3, 5], // Replace with dynamic counts
            backgroundColor: [
                getRandomColor(),
                getRandomColor(),
                getRandomColor(),
                getRandomColor(),
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
