<div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select id="customer_id" wire:model="customer_id" class="form-select">
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
            @error('customer_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="lead_status_id" class="form-label">Status</label>
            <select id="lead_status_id" wire:model="lead_status_id" class="form-select">
                <option value="">Select Status</option>
                @foreach($leadStatuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
            @error('lead_status_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="lead_source_id" class="form-label">Source</label>
            <select id="lead_source_id" wire:model="lead_source_id" class="form-select">
                <option value="">Select Source</option>
                @foreach($leadSources as $source)
                    <option value="{{ $source->id }}">{{ $source->name }}</option>
                @endforeach
            </select>
            @error('lead_source_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="segment_id" class="form-label">Segment</label>
            <select id="segment_id" wire:model.live="segment_id" class="form-select">
                <option value="">Select Segment</option>
                @foreach($segments as $segment)
                    <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                @endforeach
            </select>
            @error('segment_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="sub_segment_id" class="form-label">Sub-Segment</label>
            <select id="sub_segment_id" wire:model="sub_segment_id" class="form-select">
                <option value="">Select Sub-Segment</option>
                @foreach($subSegments as $subSegment)
                    <option value="{{ $subSegment->id }}">{{ $subSegment->name }}</option>
                @endforeach
            </select>
            @error('sub_segment_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="expected_date" class="form-label">Expected Date</label>
            <input type="date" id="expected_date" wire:model="expected_date" class="form-control">
            @error('expected_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="remark" class="form-label">Remark</label>
            <textarea id="remark" wire:model="remark" class="form-control" placeholder="description"></textarea>
            @error('remark') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-secondary">Save Lead</button>
    </form>
</div>
