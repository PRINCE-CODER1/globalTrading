<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-2">
                <h4 class="mb-0">Edit Lead</h4>
                    @if(auth()->user()->hasRole('Agent')) 
                        <a href="{{ route('agent.leads.index') }}" class="btn btn-secondary btn-wave float-end">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    @endif
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="bi bi-house-door me-1 fs-15"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('teams.index') }}"><i class="bi bi-clipboard me-1 fs-15"></i> Leads</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Lead</li>
                    </ol>
                </nav>
            </div>
        </div> 
        <hr>
    </div>
    <div class="container my-3">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-0 fw-bold">Edit Lead : <span class="text-secondary"> {{ $lead->id }}</span>
                </h1>
            </div>
        </div>
    </div>
    <div class="container mb-5">
        <div class="row">
            <!-- Lead Information Card -->
            <div class="col-md-9">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Form -->
                        <form wire:submit.prevent="save">
                            <div class="row mb-3">
                                <!-- Lead ID -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="lead_id" class="form-label fw-bold">Lead ID</label>
                                        <input type="text" id="lead_id" class="form-control" value="{{ $lead->id }}" readonly>
                                    </div>
                                </div>
                                <!-- Display the selected Lead Status in an H5 heading -->
                                <div class="col-md-6 d-flex align-items-end flex-column">
                                    <label class="fw-bold">
                                        Lead Status:     
                                    </label>
                                        @if($lead_status_id)
                                            <span class="badge bg-secondary">{{ $leadStatuses->where('id', $lead_status_id)->first()->name }}</span>
                                        @else
                                            No Status Selected
                                        @endif
                                </div>
                                
                            </div>
                            <hr>
    
                            <div class="row mb-3">
                                <!-- Created At and Updated On -->
                                <div class="col-md-6">
                                    <div class="mb-3 d-flex flex-column">
                                        <label for="created_at" class="form-label fw-bold">Created At</label>
                                        <p class="mb-0">{{ $lead->created_at->format('d-m-Y H:i') }} </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 d-flex flex-column align-items-end">
                                        <label for="updated_at" class="form-label fw-bold">Updated On</label>
                                        <p class="mb-0">{{ $lead->updated_at->format('d-m-Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                   <!-- Lead Status -->
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="lead_status_id" class="form-label fw-bold">Lead Status</label>
                                            <select id="lead_status_id" wire:model.live="lead_status_id" class="form-select">
                                                <option value="">Select Status</option>
                                                @foreach($leadStatuses as $status)
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('lead_status_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <!-- Segment and Sub-Segment -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="segment_id" class="form-label fw-bold">Segment</label>
                                        <select id="segment_id" wire:model.live="segment_id" class="form-select">
                                            <option value="">Select Segment</option>
                                            @foreach($segments as $segment)
                                                <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('segment_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sub_segment_id" class="form-label fw-bold">Sub-Segment</label>
                                        <select id="sub_segment_id" wire:model="sub_segment_id" class="form-select">
                                            <option value="">Select Sub-Segment</option>
                                            @foreach($subSegments as $subSegment)
                                                <option value="{{ $subSegment->id }}">{{ $subSegment->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('sub_segment_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="row mb-3">
                                <!-- Expected Date -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="expected_date" class="form-label fw-bold">Expected Date</label>
                                        <input type="date" id="expected_date" wire:model="expected_date" class="form-control">
                                        @error('expected_date') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <!-- Lead Source -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="lead_source_id" class="form-label fw-bold">Lead Source</label>
                                        <select id="lead_source_id" wire:model="lead_source_id" class="form-select">
                                            <option value="">Select Source</option>
                                            @foreach($leadSources as $source)
                                                <option value="{{ $source->id }}">{{ $source->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('lead_source_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <hr>
                            {{-- <!-- Add Remark -->
                            <div class="mb-3 mb-4">
                                <label for="remark" class="form-label fw-bold">Add Remark</label>
                                <textarea id="remark" wire:model="remark" class="form-control" rows="3" placeholder="Add a new remark"></textarea>
                                @error('remark') <span class="text-danger">{{ $message }}</span> @enderror
                            </div> --}}
                            <hr>
                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-secondary"><i class="ri-save-3-line"></i> Update</button>
                                @if(auth()->user()->hasRole('Agent'))
                                    <a href="{{ route('agent.leads.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-1"></i>
                                        Back
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Information Panel -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold">Lead Information</h5>
                    </div>
                    <div class="card-body">
                        <!-- Lead Created By -->
                        <div class="mb-3">
                            <h6 class="card-subtitle mb-2 text-muted fw-bold">Lead Created By:</h6>
                            <p class="card-text">{{ $lead->user->name ?? 'Unknown' }}</p>
                        </div>
    
                        <!-- Lead Assigned To -->
                        <div class="mb-3">
                            <h6 class="card-subtitle mb-2 text-muted fw-bold">Lead Assigned To:</h6>
                            <p class="card-text">
                                @if ($lead->assignedAgent)
                                    @if ($lead->assignedAgentTeams()->isNotEmpty())
                                        @foreach ($lead->assignedAgentTeams() as $team)
                                            <span class="badge bg-secondary">{{ $team->name }}</span>
                                            @if (!$loop->last) 
                                                <span> </span>
                                            @endif
                                        @endforeach
                                    @else
                                        <span>No teams assigned to the agent</span>
                                    @endif
                                @else
                                    @if ($lead->creator_id === Auth::id())
                                        <span class="badge bg-primary">Lead created by manager</span>
                                        @if ($lead->managerTeams()->isNotEmpty())
                                            @foreach ($lead->managerTeams() as $team)
                                                <span class="badge bg-secondary">{{ $team->name }}</span>
                                                @if (!$loop->last) 
                                                    <span> </span>
                                                @endif
                                            @endforeach
                                        @else
                                            <span>No teams assigned</span>
                                        @endif
                                    @else
                                        <span>No agent assigned</span>
                                    @endif
                                @endif
                            </p>
                        </div>

                        <!-- Lead Assign History -->
                        <div class="mb-3">
                            <h6 class="card-subtitle mb-2 text-muted fw-bold">Lead Assign History:</h6>
                            <ul class="list-unstyled">
                                @forelse($lead->remarks as $remark)
                                    <li>{{ $remark->user->name ?? 'Unknown User' }} - {{ $remark->created_at->format('d-m-Y H:i') }}</li>
                                @empty
                                    <p>No assignment history available.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <h2 class="fw-bold"><span class="text-secondary"> Remarks :</span>
                </h2>
                <hr>
                <hr>
            </div>
        </div>
        <div class="row">
            <!-- Remarks Section -->
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-9">                
                        <div class="card mt-3">
                            <div class="card-body">
                                <form wire:submit.prevent="addRemark">
                                    <div class="mb-3 mb-4">
                                        <label for="remark" class="form-label fw-bold">Add Remark</label>
                                        <textarea id="remark" wire:model="remark" class="form-control" rows="3" placeholder="Add a new remark" required></textarea>
                                        @error('remark') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <button type="submit" class="btn btn-secondary"><i class="ri-links-line"></i> Add Remark</button>
                                </form>
                                @forelse($remarks as $remark)
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <strong>{{ $remark->user->name ?? 'Unknown User' }}</strong>
                                            <small class="text-muted">({{ $remark->created_at->format('d-m-Y H:i') }})</small>
                                            <p class="mt-2">{{ $remark->remark }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p>No remarks available.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            
        </div>
    </div>
</div>
