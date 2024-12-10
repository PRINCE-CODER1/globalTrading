<div> 
    <div class="container mt-5">
        <div class="row mb-4">
            <h1 class="mb-4 fw-bold">Agent <span class="text-secondary">Dashboard</span></h1>
            <hr>
            <hr>
            <div class="btn-group mb-3" role="group" aria-label="Time Range Selection">
                <button type="button" class="btn btn-outline-secondary" onclick="fetchLeadsData('day')">Day</button>
                <button type="button" class="btn btn-outline-secondary" onclick="fetchLeadsData('week')">Week</button>
                <button type="button" class="btn btn-outline-secondary" onclick="fetchLeadsData('month')">Month</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h4 class="mb-4 fw-bold">Leads Overview</h4>
                    <hr>
                    <div style="max-width: 100%;max-height: 400px; margin: 0 auto;">
                        <canvas id="leadsChart" ></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container ">     
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
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Refrence Id</th>
                                        <th>Customer Name</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($leads as $lead)
                                        <tr>
                                            <td>{{ $lead->reference_id }}</td>
                                            <td>{{ $lead->customer->name }}</td>
                                            <td><span class="badge" style="background-color: {{ $lead->leadStatus->color }}; color: #fff;">{{ $lead->leadStatus->name }}</span></td>
                                            <td>{{ $lead->created_at->format('Y-m-d') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-center fw-bold" colspan="4">No records found</td>
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
    
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('leadsChart').getContext('2d');
            let leadsChart;

            function renderChart(data) {
                const labels = data.map(item => item.date);
                const newLeads = data.map(item => item.new_leads);
                const inProgressLeads = data.map(item => item.in_progress_leads);
                const completedLeads = data.map(item => item.completed_leads);
                const lostLeads = data.map(item => item.lost_leads);

                if (leadsChart) {
                    leadsChart.destroy(); // Destroy the previous chart instance if it exists
                }

                leadsChart = new Chart(ctx, {
                    type: 'bar', // You can change this to 'line', 'bar', etc.
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'New Leads',
                                data: newLeads,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'In-Progress Leads',
                                data: inProgressLeads,
                                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Completed Leads',
                                data: completedLeads,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Lost Leads',
                                data: lostLeads,
                                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1,
                            }
                        ]
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
            }

            window.addEventListener('leadsDataUpdated', event => {
                renderChart(event.detail); // Use the leads data received from the backend
            });

            // Trigger an initial chart render
            renderChart(@json($leadsPerDay)); // Ensure this variable is available in your view
        });
    </script>
    @endpush


    
</div>