<div class="container">
    
    <form wire:submit.prevent="submit" >
        <div class="row g-2 mb-2">
            <div class="mb-3">
                <label for="reference_id" class="form-label">Reference ID</label>
                <input type="text" id="reference_id" class="form-control" wire:model="referenceId" readonly>
            </div>
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
                <label for="leadtype" class="form-label fw-semibold">Lead Type</label>
                <select wire:model.live="lead_type_id" class="form-select form-select-sm">
                    <option value="">Select Lead Type</option>
                    @foreach($leadTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('lead_type_id') <span class="text-danger">{{ $message }}</span> @enderror                                    
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

            
        </div>


        <div class="row g-2 mb-2">
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
            <div class="col-md-3">
                <label for="series" class="form-label fw-semibold">Series</label>
                <select id="series" wire:model="series" class="form-select form-select-sm" required>
                    <option value="">Select Series</option>
                    @foreach($seriesList as $serie)
                        <option value="{{ $serie->id }}">{{ $serie->name }}</option>
                    @endforeach
                </select>
                @error('series') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-3">
                <label for="amount" class="form-label fw-semibold">Amount</label>
                <input type="text" wire:model="amount" id="amount" class="form-control form-control-sm" placeholder="enter amount" />
                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-3">
                <label for="application" class="form-label fw-semibold">Application</label>
                <select id="application" wire:model="application_id" class="form-select form-select-sm" required>
                    <option value="">Select application</option>
                    @foreach($applications as $application)
                        <option value="{{ $application->id }}">{{ $application->name }}</option>
                    @endforeach
                </select>
                @error('application') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            @if($showContractOptions)
            <div>
                <label for="contractor_ids">Select Contractors</label>
                <select id="contractor_ids" class="form-control" wire:model="contractor_ids" multiple>
                    @foreach ($contractors as $contractor)
                        <option value="{{ $contractor->id }}" 
                            @if(in_array($contractor->id, $contractor_ids)) selected @endif>
                            {{ $contractor->name }}
                        </option>
                    @endforeach
                </select>
                @error('contractor_ids') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            @endif

            @push('scripts')
            <script>
                document.addEventListener('livewire:load', function () {
                    $('#contractor').select2();

                    // Trigger Livewire update when the dropdown value changes
                    $('#contractor').on('change', function () {
                        let data = $(this).val(); // Get the selected values
                        @this.set('contractor_id', data); // Pass the data to Livewire
                    });

                    // Reinitialize Select2 when Livewire updates the dropdown
                    Livewire.hook('message.processed', (message, component) => {
                        $('#contractor').select2();
                    });
                });
            </script>
            @endpush
            <div class="mb-3">
                <label for="specification" class="form-label fw-semibold">Specification</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="specification" id="specificationFavourable" value="favourable"
                           wire:model="specification" {{ $specification === 'favourable' ? 'checked' : '' }}>
                    <label class="form-check-label" for="specificationFavourable">
                        Favourable
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="specification" id="specificationNonFavourable" value="non-favourable"
                           wire:model="specification" {{ $specification === 'non-favourable' ? 'checked' : '' }}>
                    <label class="form-check-label" for="specificationNonFavourable">
                        Non-Favourable
                    </label>
                </div>
                @error('specification')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-secondary btn-sm me-2"><i class="ri-add-circle-line"></i> Create Lead</button>
            <a href="{{ route('leads.index') }}" class="btn btn-danger btn-sm">Cancel</a>
        </div>
    </form>
</div>
