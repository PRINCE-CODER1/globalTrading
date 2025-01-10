@extends('website.master')

@section('content')
<div class="container mt-5">
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Teams</h4>
            <a href="{{ route('teams.index') }}" class="btn btn-secondary"><i class="ri-arrow-left-s-line"></i> Back</a>
        </div>
    </div>
    <hr>

    <!-- Title -->
    <div class="row">
        <div class="col-12">
            <h2 class="fw-bold">Assign Agents to Team: <span class="text-secondary">{{ $team->name }}</span></h2>
        </div>
    </div>
    
    <!-- Search Bar -->
    <div class="row mt-4 d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8 ">
            <div class="input-group">
                <input type="text" id="searchAgents" class="form-control rounded-pill shadow-sm" placeholder="Search Agents" aria-label="Search Agents">
                <button class="btn btn-outline-secondary rounded-pill ms-2" id="clearSearch" type="button">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Agent Assignment Form -->
    <div class="row mt-4 d-flex justify-content-center">
        <div class="col-12 col-md-8 bg-white p-4 rounded shadow-sm">
            <form action="{{ route('manager.teams.assign-agents', $team->id) }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label for="agents" class="form-label fw-semibold"><i class="ri-chat-check-line"></i> Select Agents:</label>
                    <div class="d-flex flex-wrap" id="agentList">
                        @foreach($agents as $agent)
                            <div class="form-check me-3 mb-2 agent-item" data-agent-name="{{ strtolower($agent->name) }}">
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
                <button type="submit" class="btn btn-secondary mt-3 w-100 shadow-sm"><i class="ri-save-line"></i> Assign Agents</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Search functionality
    document.getElementById('searchAgents').addEventListener('input', function(e) {
        const searchValue = e.target.value.toLowerCase();
        const agentItems = document.querySelectorAll('.agent-item');
        
        agentItems.forEach(item => {
            const agentName = item.getAttribute('data-agent-name');
            if (agentName.includes(searchValue)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Clear Search functionality
    document.getElementById('clearSearch').addEventListener('click', function() {
        document.getElementById('searchAgents').value = '';
        document.querySelectorAll('.agent-item').forEach(item => item.style.display = 'block');
    });
</script>
@endpush

@endsection
