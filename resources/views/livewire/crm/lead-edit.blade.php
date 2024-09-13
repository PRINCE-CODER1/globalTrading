<div class="container my-5">
    <div class="row">
        <!-- Lead Information Card -->
        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Edit Lead</h5>
                </div>
                <div class="card-body">
                    <!-- Form -->
                    <form wire:submit.prevent="save">
                        <div class="row mb-3">
                            <!-- Lead ID -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lead_id">Lead ID</label>
                                    <input type="text" id="lead_id" class="form-control" value="{{ $lead->id }}" readonly>
                                </div>
                            </div>
                            <!-- Lead Status -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lead_status_id">Lead Status</label>
                                    <select id="lead_status_id" wire:model="lead_status_id" class="form-control">
                                        <option value="">Select Status</option>
                                        @foreach($leadStatuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('lead_status_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Created At and Updated On -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="created_at">Created At</label>
                                    <input type="text" id="created_at" class="form-control" value="{{ $lead->created_at->format('d-m-Y H:i') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="updated_at">Updated On</label>
                                    <input type="text" id="updated_at" class="form-control" value="{{ $lead->updated_at->format('d-m-Y H:i') }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Segment and Sub-Segment -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="segment_id">Segment</label>
                                    <select id="segment_id" wire:model.live="segment_id" class="form-control">
                                        <option value="">Select Segment</option>
                                        @foreach($segments as $segment)
                                            <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('segment_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sub_segment_id">Sub-Segment</label>
                                    <select id="sub_segment_id" wire:model="sub_segment_id" class="form-control">
                                        <option value="">Select Sub-Segment</option>
                                        @foreach($subSegments as $subSegment)
                                            <option value="{{ $subSegment->id }}">{{ $subSegment->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sub_segment_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Expected Date -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expected_date">Expected Date</label>
                                    <input type="date" id="expected_date" wire:model="expected_date" class="form-control">
                                    @error('expected_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <!-- Lead Source -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lead_source_id">Lead Source</label>
                                    <select id="lead_source_id" wire:model="lead_source_id" class="form-control">
                                        <option value="">Select Source</option>
                                        @foreach($leadSources as $source)
                                            <option value="{{ $source->id }}">{{ $source->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('lead_source_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Add Remark -->
                        <div class="form-group mb-4">
                            <label for="remark">Add Remark</label>
                            <textarea id="remark" wire:model="remark" class="form-control" rows="3" placeholder="Add a new remark"></textarea>
                            @error('remark') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('agent.leads.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Information Panel -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Lead Information</h5>
                </div>
                <div class="card-body">
                    <!-- Lead Created By -->
                    <div class="mb-3">
                        <h6 class="card-subtitle mb-2 text-muted">Lead Created By:</h6>
                        <p class="card-text">{{ $lead->user->name ?? 'Unknown' }}</p>
                    </div>

                    <!-- Lead Assigned To -->
                    <div class="mb-3">
                        <h6 class="card-subtitle mb-2 text-muted">Lead Assigned To:</h6>
                        <p class="card-text">
                            @if($lead->assignedAgentTeam())
                                {{ $lead->assignedAgentTeam()->name }}
                                @else
                                    No team assigned
                            @endif
                    </p>
                    </div>

                    <!-- Lead Assign History -->
                    <div class="mb-3">
                        <h6 class="card-subtitle mb-2 text-muted">Lead Assign History:</h6>
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
        <!-- Remarks Section -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Remarks</h5>
                </div>
                <div class="card-body">
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
