@extends('website.master')

@section('content')

{{-- <div class="container">
    <h2>{{ $manager->name }} Leads</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Lead ID</th>
                <th>Lead Name</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leads as $lead)
                <tr>
                    <td>{{ $lead->id }}</td>
                    <td>{{ $lead->leadStatus->name }}</td>
                    <td>{{ $lead->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}

<div class="container mt-5">
    <div class="row">
        <div class="col-12 col-md-8">
            <!-- Manager Details -->
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="mb-0 text-center">Manager Details</h3>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $manager->name }}</p>
                    <p><strong>Email:</strong> {{ $manager->email }}</p>
                    <p><strong>Teams Managed:</strong> {{ $teams->count()  }}</p>
                    {{-- <p><strong>Agents Under Manager:</strong> {{ $agents->count() }}</p> --}}
                </div>
            </div>
        </div>
    </div>
 
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Manager's Teams</h3>
                        <p class="mb-0 text-dark">Details of teams managed by {{ $manager->name }}</p>
                    </div>
                    <div class="card-body">
                        @if ($teams->isEmpty())
                            <p class="text-dark">No teams found for this manager.</p>
                        @else
                            <table class="table table-bordered table-striped">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Team Name</th>
                                        <th scope="col">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teams as $index => $team)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $team->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($team->created_at)->format('d M Y, H:i') }}</td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- <!-- Leads Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Leads Created by Manager</h5>
                </div>
                <div class="card-body">
                    @if($leads->isEmpty())
                        <p>No leads created by this manager yet.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Lead ID</th>
                                    <th>Lead Reference Id</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leads as $lead)
                                    <tr>
                                        <td>{{ $lead->id }}</td>
                                        <td>{{ $lead->reference_id }}</td>
                                        <td>{{ $lead->leadStatus->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Teams and Agents Details -->
    {{-- <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Teams and Agents Under Manager</h5>
                </div>
                <div class="card-body">
                    @if($teams->isEmpty())
                        <p>No teams assigned to this manager.</p>
                    @else
                        <ul class="list-group">
                            @foreach($teams as $team)
                                <li class="list-group-item">
                                    <strong>{{ $team->name }}</strong>
                                    <ul>
                                        @foreach($team->agents as $agent)
                                            <li>{{ $agent->name }}</li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div> --}}
</div>


@endsection
