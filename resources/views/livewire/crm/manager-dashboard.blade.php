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
                      <span class="fs-12 op-7 ms-1">
                        <i class="ti ti-trending-{{ $percentageChange >= 0 ? 'up' : 'down' }} me-1 d-inline-block"></i>
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
    
        <!-- Team Performance -->
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
                                        <h4 class="mt-1">Leads Assigned: {{ $team->members->sum('leads_count') }}</h4>
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
    <div class="container">     
        <div class="row mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Lead Search and Filter -->
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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Leads Table -->
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="fw-bold">Customer</th>
                                        <th class="fw-bold">Assigned Agent</th>
                                        <th class="fw-bold">Status</th>
                                        <th class="fw-bold">Source</th>
                                        <th class="fw-bold">Expected Date</th>
                                        <th class="fw-bold">Last Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leads as $lead)
                                        <tr>
                                            <td>{{ $lead->customer->name }}</td>
                                            <td>{{ $lead->assignedAgent->name }}</td>
                                            <td><span class="badge" style="background-color: {{ $lead->leadStatus->color }}; color: #fff;">{{ $lead->leadStatus->name }}</span></td>
                                            <td>{{ $lead->leadSource->name }}</td>
                                            <td>{{ $lead->expected_date ? \Carbon\Carbon::parse($lead->expected_date)->format('Y-m-d') : 'N/A' }}</td>
                                            <td>{{ $lead->updated_at->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        
                            {{ $leads->links('custom-pagination-links') }} 
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">     
        <div class="row mb-3">
                <!-- Lead Logs -->
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
                <div class="col-md-7">
                    <div class="mt-5" style="height:400px">
                        <h4 class="mb-4 fw-bold">Lead Status Overview</h4>
                        <hr>
                       <div>
                        <canvas  id="leadsChart"></canvas>
                       </div>
                    </div>
                </div>  
        </div>
    </div> 
    @push('scripts')
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
    @endpush
</div>