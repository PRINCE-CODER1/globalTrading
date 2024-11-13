@extends('website.master')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card shadow-sm">
                <div class="bg-secondary text-white p-3">
                    <h3 class="mb-0 text-white">Manager's Teams</h3>
                    <p class="mb-0 text-white">Details of teams managed by {{ $manager->name }}</p>
                </div>
                <div class="card-body table-responsive">
                    @if ($teams->isEmpty())
                        <p class="text-dark">No teams found for this manager.</p>
                    @else
                        <table class="table table-striped">
                            <thead class="table-secondary">
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
        <div class="col-12 col-md-4">
            <!-- Manager Details -->
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="bg-secondary  p-3">
                    <h3 class="mb-0 text-center text-white">Manager Details</h3>
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
    <!-- Agents in Manager's Team -->
    <div class="card">
        <div class="bg-secondary p-3">
            <h3 class="mb-0 text-white">Manager: {{ $manager->name }} - Teams & Agents</h3>
        </div>
        <div class="card-body">
            @foreach($teams as $team)
                <h4>Team: {{ $team->name }}</h4>
                @if($team->agents->isEmpty())
                    <p>No agents assigned to this team.</p>
                @else
                    <table class="table table-striped mb-2">
                        <thead>
                            <tr>
                                <th>Agent Name</th>
                                <th>Email</th>
                                <th>Leads</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($team->agents as $agent)
                                <tr>
                                    <td>
                                        <a href="{{ route('lead.agent', $agent->id) }}"
                                        class="text-decoration-none text-dark">
                                        {{ $agent->name }}
                                        </a>
                                    </td>
                                    <td>{{ $agent->email }}</td>
                                    <td>{{ $agent->leads->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endforeach
        </div>
    </div>
    

    <!-- Leads Section -->
    {{-- <div class="row mt-5">
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
