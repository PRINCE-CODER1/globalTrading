@extends('website.master')  <!-- Assuming you have a base layout -->

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow my-5">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Lead - {{ $lead->id }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('agent.leads.update', $lead->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Customer -->
                        <div class="form-group mb-3">
                            <label for="customer_id">Customer</label>
                            <select name="customer_id" id="customer_id" class="form-control">
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ $lead->customer_id == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Lead Status -->
                        <div class="form-group mb-3">
                            <label for="lead_status_id">Lead Status</label>
                            <select name="lead_status_id" id="lead_status_id" class="form-control">
                                @foreach ($leadStatuses as $status)
                                    <option value="{{ $status->id }}" {{ $lead->lead_status_id == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lead_status_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Lead Source -->
                        <div class="form-group mb-3">
                            <label for="lead_source_id">Lead Source</label>
                            <select name="lead_source_id" id="lead_source_id" class="form-control">
                                @foreach ($leadSources as $source)
                                    <option value="{{ $source->id }}" {{ $lead->lead_source_id == $source->id ? 'selected' : '' }}>
                                        {{ $source->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lead_source_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Segments -->
                        <div class="form-group mb-3">
                            <label for="segment_id">Segment</label>
                            <select name="segment_id" id="segment_id" class="form-control">
                                @foreach ($segments as $segment)
                                    <option value="{{ $segment->id }}" {{ $lead->segment_id == $segment->id ? 'selected' : '' }}>
                                        {{ $segment->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('segment_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Sub-Segments (Optional) -->
                        <div class="form-group mb-3">
                            <label for="sub_segment_id">Sub-Segment (Optional)</label>
                            <select name="sub_segment_id" id="sub_segment_id" class="form-control">
                                <option value="">Select Sub-Segment</option>
                                @foreach ($subSegments as $subSegment)
                                    <option value="{{ $subSegment->id }}" {{ $lead->sub_segment_id == $subSegment->id ? 'selected' : '' }}>
                                        {{ $subSegment->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sub_segment_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Expected Date -->
                        <div class="form-group mb-3">
                            <label for="expected_date">Expected Close Date</label>
                            <input type="date" name="expected_date" id="expected_date" class="form-control" value="{{ \carbon\carbon::parse($lead->expected_date)->format('Y-m-d') }}">
                            @error('expected_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Old Remarks -->
                        <!-- Old Remarks -->
                        <div class="form-group mb-3">
                            <label>All Remarks</label>
                            <ul class="list-group">
                                @forelse ($remarks as $remark)
                                    <li class="list-group-item">
                                        <strong>{{ $remark->created_at->format('Y-m-d H:i') }}</strong> by {{ $remark->user->name }}
                                        <p>{{ $remark->remark }}</p>
                                    </li>
                                @empty
                                    <li class="list-group-item">No remarks yet.</li>
                                @endforelse
                            </ul>
                        </div>

                         <!-- Remarks -->
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                @foreach($lead->remarks as $remark)
                                    <textarea name="remark" id="remark" class="form-control" rows="3">{{ old('remark', $remark->remark ?? '') }}</textarea>
                                @endforeach
                                @error('remark')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        <!-- Action Buttons -->
                        <div class="form-group d-flex justify-content-between">
                            <a href="{{ route('agent.leads.index') }}" class="btn btn-secondary">Back to List</a>
                            <button type="submit" class="btn btn-primary">Update Lead</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@livewire('crm.lead-edit', ['leadId' => $lead->id])
@endsection

{{-- @extends('website.master')  <!-- Assuming you have a base layout -->

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="container">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit Lead - {{ $lead->id }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('agent.leads.update', $lead->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <!-- Customer -->
                            <div class="form-group mb-3">
                                <label for="customer_id">Customer</label>
                                <select name="customer_id" id="customer_id" class="form-control">
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $lead->customer_id == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
    
                            <!-- Lead Status -->
                            <div class="form-group mb-3">
                                <label for="lead_status_id">Lead Status</label>
                                <select name="lead_status_id" id="lead_status_id" class="form-control">
                                    @foreach ($leadStatuses as $status)
                                        <option value="{{ $status->id }}" {{ $lead->lead_status_id == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lead_status_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
    
                            <!-- Lead Source -->
                            <div class="form-group mb-3">
                                <label for="lead_source_id">Lead Source</label>
                                <select name="lead_source_id" id="lead_source_id" class="form-control">
                                    @foreach ($leadSources as $source)
                                        <option value="{{ $source->id }}" {{ $lead->lead_source_id == $source->id ? 'selected' : '' }}>
                                            {{ $source->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lead_source_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
    
                            <!-- Segments -->
                            <div class="form-group mb-3">
                                <label for="segment_id">Segment</label>
                                <select name="segment_id" id="segment_id" class="form-control">
                                    @foreach ($segments as $segment)
                                        <option value="{{ $segment->id }}" {{ $lead->segment_id == $segment->id ? 'selected' : '' }}>
                                            {{ $segment->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('segment_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
    
                            <!-- Sub-Segments (Optional) -->
                            <div class="form-group mb-3">
                                <label for="sub_segment_id">Sub-Segment</label>
                                <select name="sub_segment_id" id="sub_segment_id" class="form-control">
                                    <option value="">Select Sub-Segment</option>
                                    @foreach ($subSegments as $subSegment)
                                        <option value="{{ $subSegment->id }}" {{ $lead->sub_segment_id == $subSegment->id ? 'selected' : '' }}>
                                            {{ $subSegment->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sub_segment_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
    
                            <!-- Expected Date -->
                            <div class="form-group mb-3">
                                <label for="expected_date">Expected Close Date</label>
                                <input type="date" name="expected_date" id="expected_date" class="form-control" value="{{ \carbon\carbon::parse($lead->expected_date)->format('Y-m-d') }}">
                                @error('expected_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
    
                            <!-- Remarks -->
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                @foreach($lead->remarks as $remark)
                                    <textarea name="remark" id="remark" class="form-control" rows="3">{{ old('remark', $remark->remark ?? '') }}</textarea>
                                @endforeach
                                @error('remark')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
    
                            <!-- Action Buttons -->
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ route('agent.leads.index') }}" class="btn btn-secondary">Back to List</a>
                                <button type="submit" class="btn btn-primary">Update Lead</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


