<div class="container">
    {{-- <h1 class="h4 mb-3">Create Lead</h1> --}}
    
    <form wire:submit.prevent="submit">
        <div class="row g-2 mb-2">
            <div class="col-md-3">
                <label for="customer_id" class="form-label fw-semibold">Customer</label>
                <select id="customer_id" wire:model="customer_id" class="form-select form-select-sm" required>
                    <option value="">Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
                @error('customer_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-3">
                <label for="lead_status_id" class="form-label fw-semibold">Lead Status</label>
                <select id="lead_status_id" wire:model="lead_status_id" class="form-select form-select-sm" required>
                    <option value="">Select Lead Status</option>
                    @foreach($leadStatuses as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
                @error('lead_status_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-3">
                <label for="lead_source_id" class="form-label fw-semibold">Lead Source</label>
                <select id="lead_source_id" wire:model="lead_source_id" class="form-select form-select-sm" required>
                    <option value="">Select Lead Source</option>
                    @foreach($leadSources as $source)
                        <option value="{{ $source->id }}">{{ $source->name }}</option>
                    @endforeach
                </select>
                @error('lead_source_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-3">
                <label for="segment_id" class="form-label fw-semibold">Segment</label>
                <select id="segment_id" wire:model.live="segment_id" class="form-select form-select-sm" required>
                    <option value="">Select Segment</option>
                    @foreach($segments as $segment)
                        <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                    @endforeach
                </select>
                @error('segment_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>


        <div class="row g-2 mb-2">
            <div class="col-md-3">
                <label for="sub_segment_id" class="form-label fw-semibold">Sub-Segment</label>
                <select id="sub_segment_id" wire:model="sub_segment_id" class="form-select form-select-sm">
                    <option value="">Select Sub-Segment</option>
                    @foreach($subSegments as $subSegment)
                        <option value="{{ $subSegment->id }}">{{ $subSegment->name }}</option>
                    @endforeach
                </select>
                @error('sub_segment_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-3">
                <label for="expected_date" class="form-label fw-semibold">Expected Date</label>
                <input type="date" id="expected_date" wire:model="expected_date" class="form-control form-control-sm" required>
                @error('expected_date') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-3">
                <label for="category_id" class="form-label fw-semibold">Stock Category</label>
                <select id="category_id" wire:model.live="category_id" class="form-select form-select-sm">
                    <option value="">Select Stock Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-3">
                <label for="child_category_id" class="form-label fw-semibold">Child Category</label>
                <select id="child_category_id" wire:model.live="child_category_id" class="form-select form-select-sm">
                    <option value="">Select Child Category</option>
                    @foreach($childCategories as $childCategory)
                        <option value="{{ $childCategory->id }}">{{ $childCategory->name }}</option>
                    @endforeach
                </select>
                @error('child_category_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-md-12">
                <label for="series" class="form-label fw-semibold">Series</label>
                <select id="series" wire:model="series" class="form-select form-select-sm" required>
                    <option value="">Select Series</option>
                    @foreach($seriesList as $serie)
                        <option value="{{ $serie->id }}">{{ $serie->name }}</option>
                    @endforeach
                </select>
                @error('series') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-secondary btn-sm me-2"><i class="ri-add-circle-line"></i> Create Lead</button>
            <a href="{{ route('agent.leads.index') }}" class="btn btn-danger btn-sm">Cancel</a>
        </div>
    </form>
</div>
