@extends('website.master')

@section('content')
<div class="container">
    <div class="row mt-5 mb-3">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Teams</h4>
            <a href="{{ route('teams.index') }}" class="btn btn-secondary"><i class="ri-arrow-left-s-line"></i> Back</a>
        </div>
    </div>
    <hr>
</div>
<div class="container">
    <h2 class="fw-bold">Assign Agents to Team: <span class="text-secondary">{{ $team->name }}</span></h2>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">    
            <form action="{{ route('manager.teams.assign-agents', $team->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="agents" class="form-label"><h6 class="fw-semibold"><i class="ri-chat-check-line"></i> Select Agents:</h6></label>
                    <div class="d-flex flex-wrap">
                        @foreach($agents as $agent)
                            <div class="form-check me-3">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="agents[]" 
                                    id="agent-{{ $agent->id }}" 
                                    value="{{ $agent->id }}" 
                                    {{ $team->agents->contains($agent->id) ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="agent-{{ $agent->id }}">
                                    {{ $agent->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-secondary mt-3"><i class="ri-save-line"></i> Assign Agents</button>
            </form>
        </div>
    </div>
</div>
@endsection
