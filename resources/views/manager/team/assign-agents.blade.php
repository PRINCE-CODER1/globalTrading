@extends('website.master')

@section('content')
<div class="container">
    <h2>Assign Agents to Team: {{ $team->name }}</h2>

    <form action="{{ route('manager.teams.assign-agents', $team->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="agents">Select Agents</label>
            <select name="agents[]" id="agents" class="form-control" multiple>
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" {{ $team->agents->contains($agent->id) ? 'selected' : '' }}>
                        {{ $agent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Assign Agents</button>
    </form>
</div>
@endsection
