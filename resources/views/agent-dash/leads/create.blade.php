@extends('website.master') <!-- Assuming you're using a layout file -->

@section('content')
@livewire('crm.lead-create')
{{-- <div class="container">
    <h1>Create Lead</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('agent.leads.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select name="customer_id" id="customer_id" class="form-select" required>
                <option value="">Select Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="lead_status_id" class="form-label">Lead Status</label>
            <select name="lead_status_id" id="lead_status_id" class="form-select" required>
                <option value="">Select Lead Status</option>
                @foreach ($leadStatuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="lead_source_id" class="form-label">Lead Source</label>
            <select name="lead_source_id" id="lead_source_id" class="form-select" required>
                <option value="">Select Lead Source</option>
                @foreach ($leadSources as $source)
                    <option value="{{ $source->id }}">{{ $source->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="segment_id" class="form-label">Segment</label>
            <select name="segment_id" id="segment_id" class="form-select" required>
                <option value="">Select Segment</option>
                @foreach ($segments as $segment)
                    <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="sub_segment_id" class="form-label">Sub-Segment</label>
            <select name="sub_segment_id" id="sub_segment_id" class="form-select">
                <option value="">Select Sub-Segment</option>
                @foreach ($subSegments as $segment)
                    <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="remark">Remark</label>
            <textarea name="remark" id="remark" class="form-control" rows="3">{{ old('remark') }}</textarea>
            @error('remark')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="expected_date" class="form-label">Expected Date</label>
            <input type="date" name="expected_date" id="expected_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Lead</button>
    </form>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const segmentSelect = document.getElementById('segment_id');
        const subSegmentSelect = document.getElementById('sub_segment_id');

        segmentSelect.addEventListener('change', function () {
            const segmentId = this.value;
            
            if (segmentId) {
                fetch(`/api/sub-segments/${segmentId}`)
                    .then(response => response.json())
                    .then(data => {
                        subSegmentSelect.innerHTML = '<option value="">Select Sub-Segment</option>';
                        data.forEach(subSegment => {
                            const option = document.createElement('option');
                            option.value = subSegment.id;
                            option.textContent = subSegment.name;
                            subSegmentSelect.appendChild(option);
                        });
                    });
            } else {
                subSegmentSelect.innerHTML = '<option value="">Select Sub-Segment</option>';
            }
        });
    });
</script>
@endsection --}}
@endsection
