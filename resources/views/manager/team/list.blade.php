@extends('website.master')

@section('content')
{{-- <div class="container">
    <h2>Teams</h2>
    <a href="{{route('teams.create')}}" class="btn btn-sm btn-secondary">create</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Team Name</th>
                <th>Assigned Agents</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teams as $team)
                <tr>
                    <td>{{ $team->id }}</td>
                    <td>{{ $team->name }}</td>
                    <td>
                        @if($team->agents->isEmpty())
                            <span>No agents assigned</span>
                        @else
                        <ul>
                            @foreach($team->agents as $agent)
                                <li>
                                    <a href="{{ route('agents.leads', $agent->id) }}">{{ $agent->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('teams.edit', $team) }}" class="btn btn-warning">Edit</a>
                        
                        <form action="{{ route('teams.destroy', $team) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                        <!-- Link to assign agents page -->
                        <a href="{{ route('manager.teams.show-assign-form', $team->id) }}" class="btn btn-info">Assign Agents</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}
@livewire('crm.team-list')
@endsection
