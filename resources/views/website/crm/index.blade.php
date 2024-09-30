@extends('website.master')
@section('content')
<!-- Start::app-content -->
<div class="main-content">
    <div class="container my-5">
        <div class="row">
            <div class="col-xl-9">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            <h3 class="fw-bold">Recent Leads</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th class="fw-bold">ID</th>
                                        <th class="fw-bold">Customer</th>
                                        <th class="fw-bold">Lead Source</th>
                                        <th class="fw-bold">Assigned To</th>
                                        <th class="fw-bold">Capture Date</th>
                                        <th class="fw-bold">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentLeads as $lead)
                                    <tr>
                                        <td>{{ $lead->id }}</td>
                                        <td>{{ $lead->customer->name }}</td>
                                        <td>{{ $lead->leadSource->name }}</td>
                                        <td>{{ $lead->assignedAgent->name }}</td>
                                        <td>{{ $lead->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $lead->leadStatus->name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
            
            <!-- Lead Source Breakdown -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bold">Lead Source Breakdown</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="leadSourceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            
            
            <!-- Lead Assignment Overview (ApexCharts) -->
            <div class="col-md-5">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="fw-bold">Lead Assignment Overview</h3>
                    </div>
                    <div class="card-body">
                        <div id="leadAssignmentChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Lead Source Chart using Chart.js
    var ctx1 = document.getElementById('leadSourceChart').getContext('2d');
    var leadSourceChart = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: @json($leadSourceData->pluck('source')),
            datasets: [{
                data: @json($leadSourceData->pluck('count')),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
            }]
        }
    });
</script>

<!-- Include ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Lead Assignment Chart using ApexCharts
    var leadAssignmentChartOptions = {
        chart: {
            type: 'bar'
        },
        series: [{
            name: 'Leads Assigned',
            data: @json($leadAssignmentData->pluck('count'))
        }],
        xaxis: {
            categories: @json($leadAssignmentData->pluck('assigned_to'))
        },
        colors: ['#36A2EB']
    };

    var leadAssignmentChart = new ApexCharts(document.querySelector("#leadAssignmentChart"), leadAssignmentChartOptions);
    leadAssignmentChart.render();
</script>

@endpush
@endsection
