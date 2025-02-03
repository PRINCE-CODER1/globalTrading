<div class="container">

    <form wire:submit.prevent="submit">
        <div class="row g-2 mb-2">
            <div class="mb-3">
                <label for="reference_id" class="form-label fw-semibold">Reference ID</label>
                <input type="text" id="reference_id" class="form-control" wire:model="referenceId" readonly>
            </div>
            {{-- <div class="col-md-3">
                <label for="customer_id" class="form-label fw-semibold">Customer</label>
                <div class="dropdown position-relative">
                    <input 
                        id="customer-search" 
                        type="text" 
                        placeholder="Search Customer" 
                        class="form-control form-control-sm mb-1 d-none" 
                    >
                    <select id="customer-select" wire:model="customer_id" class="form-select form-select-sm" required>
                        <option value="">Select Customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('customer_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div> --}}
            <div class="col-md-3">
                {{-- <label for="customer_id" class="form-label fw-semibold">Customer</label>
                <div class="position-relative">
                    <!-- Search Input -->
                    <input type="text" placeholder="Search Customer" class="form-control form-control-sm mb-1"
                        wire:model.live="search" autocomplete="off" wire:focus="showDropdown" wire:blur="hideDropdown">

                    <!-- Dropdown List -->
                    @if ($showDropdown)
                        <ul class="list-group position-absolute w-100"
                            style="z-index: 1050; max-height: 200px; overflow-y: auto;"
                            wire:mouseenter="keepDropdownOpen" wire:mouseleave="hideDropdown">
                            @forelse($allCustomer as $customer)
                                <li wire:click="selectCustomer({{ $customer->id }})"
                                    class="list-group-item list-group-item-action {{ $customer_id === $customer->id ? 'active' : '' }}"
                                    style="cursor: pointer;">
                                    {{ $customer->name }}
                                </li>
                            @empty
                                <li class="list-group-item text-muted">No customers found</li>
                            @endforelse
                        </ul>
                    @endif
                </div>

                <!-- Error Message -->
                @error('customer_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror --}}
                <style>
                    .relative {
                        position: relative;
                    }

                    .absolute {
                        position: absolute;
                        top: 100%;
                        left: 0;
                    }

                    .bg-white {
                        background-color: white;
                    }

                    .border {
                        border: 1px solid #ddd;
                    }

                    .rounded {
                        border-radius: 4px;
                    }

                    .shadow {
                        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
                    }

                    .cursor-pointer {
                        cursor: pointer;
                    }

                    .hover\:bg-gray-200:hover {
                        background-color: #f7f7f7;
                    }

                    .z-50 {
                        z-index: 50;
                    }
                </style>
                <div class="relative w-80">
                    <!-- Search Input -->
                    <input type="text" wire:model.live="search" placeholder="Search customers by name..."
                        class="form-control form-control-sm border rounded" />

                    <!-- Dropdown List -->
                    @if (!empty($filteredCustomers))
                        <div class="absolute z-50 w-full bg-white border rounded shadow mt-1">
                            @foreach ($filteredCustomers as $key => $customer)
                                <div wire:click="selectCustomer({{ $customer['id'] }})"
                                    class="p-2 cursor-pointer hover:bg-gray-200">
                                    <b>{{ $customer['name'] }}</b> - {{ $customer['mobile_no'] }}
                                </div>
                                @if ($key >= 4)
                                    @php
                                        break;
                                    @endphp
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <!-- Selected Customer Display -->
                    @if ($selectedCustomer)
                        <div class="mt-2 p-2 bg-green-100 border rounded">
                            <strong>Selected:</strong> {{ $selectedCustomer['name'] }} <br>
                        </div>
                    @endif
                </div>
            </div>
            

            <style>
                .list-group-item {
                    padding: 0.5rem 1rem;
                }

                .list-group-item:hover {
                    background-color: #f8f9fa;
                }

                .list-group-item.active {
                    background-color: #0d6efd;
                    color: #fff;
                }
            </style>
            @if($selectedCustomerUsers)
            <div class="col-md-3">
                <label for="customer_user" class="form-label fw-semibold">Customer User</label>
                <select wire:model="customer_supplier_user_id" id="customer_user" class="form-select form-select-sm">
                    <option value="">Select Customer User</option>
                    @foreach($selectedCustomerUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                @error('customer_supplier_user_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            @endif
            <div class="col-md-3">
                <label for="lead_status_id" class="form-label fw-semibold">Lead Status</label>
                <select id="lead_status_id" wire:model="lead_status_id" class="form-select form-select-sm" required>
                    <option value="">Select Lead Status</option>
                    @foreach ($leadStatuses as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
                @error('lead_status_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="leadtype" class="form-label fw-semibold">Lead Type</label>
                <select wire:model.live="lead_type_id" class="form-select form-select-sm">
                    <option value="">Select Lead Type</option>
                    @foreach ($leadTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('lead_type_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="lead_source_id" class="form-label fw-semibold">Lead Source</label>
                <select id="lead_source_id" wire:model="lead_source_id" class="form-select form-select-sm" required>
                    <option value="">Select Lead Source</option>
                    @foreach ($leadSources as $source)
                        <option value="{{ $source->id }}">{{ $source->name }}</option>
                    @endforeach
                </select>
                @error('lead_source_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


        </div>


        <div class="row g-2 mb-2">
            <div class="col-md-3">
                <label for="segment_id" class="form-label fw-semibold">Segment</label>
                <select id="segment_id" wire:model.live="segment_id" class="form-select form-select-sm" required>
                    <option value="">Select Segment</option>
                    @foreach ($segments as $segment)
                        <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                    @endforeach
                </select>
                @error('segment_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="sub_segment_id" class="form-label fw-semibold">Sub-Segment</label>
                <select id="sub_segment_id" wire:model="sub_segment_id" class="form-select form-select-sm">
                    <option value="">Select Sub-Segment</option>
                    @foreach ($subSegments as $subSegment)
                        <option value="{{ $subSegment->id }}">{{ $subSegment->name }}</option>
                    @endforeach
                </select>
                @error('sub_segment_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="expected_date" class="form-label fw-semibold">Expected Date</label>
                <input type="month" id="expected_date" wire:model="expected_date" class="form-control form-control-sm"
                    required>
                @error('expected_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="category_id" class="form-label fw-semibold">Stock Category</label>
                <select id="category_id" wire:model.live="category_id" class="form-select form-select-sm">
                    <option value="">Select Stock Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="child_category_id" class="form-label fw-semibold">Child Category</label>
                <select id="child_category_id" wire:model.live="child_category_id" class="form-select form-select-sm">
                    <option value="">Select Child Category</option>
                    @foreach ($childCategories as $childCategory)
                        <option value="{{ $childCategory->id }}">{{ $childCategory->name }}</option>
                    @endforeach
                </select>
                @error('child_category_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="series" class="form-label fw-semibold">Series</label>
                <select id="series" wire:model="series" class="form-select form-select-sm" required>
                    <option value="">Select Series</option>
                    @foreach ($seriesList as $serie)
                        <option value="{{ $serie->id }}">{{ $serie->name }}</option>
                    @endforeach
                </select>
                @error('series')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="amount" class="form-label fw-semibold">Amount</label>
                <input type="text" wire:model="amount" id="amount" class="form-control form-control-sm"
                    placeholder="enter amount" />
                @error('amount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="application" class="form-label fw-semibold">Application</label>
                <select id="application" wire:model="application_id" class="form-select form-select-sm" required>
                    <option value="">Select application</option>
                    @foreach ($applications as $application)
                        <option value="{{ $application->id }}">{{ $application->name }}</option>
                    @endforeach
                </select>
                @error('application')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @if ($showContractOptions)
                {{-- <div class="col-md-6">
                    <label for="contractor_ids" class="fw-semibold">Select Contractors</label>
                    <select id="contractor_ids" class="form-control" wire:model="contractor_ids" multiple>
                        @foreach ($contractors as $contractor)
                            <option value="{{ $contractor->id }}" @if (in_array($contractor->id, $contractor_ids)) selected @endif>
                                {{ $contractor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('contractor_ids')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}
                <div class="col-md-4">
                    <div class="col-md-12">
                        <h4 class="text-secondary"><i class="ri-contacts-line"></i> Select Contractors</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>#</th>
                                        <th>Contractor</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contractor_ids as $index => $contractorId)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <select wire:model="contractor_ids.{{ $index }}" class="form-control">
                                                    <option value="">Select Contractor</option>
                                                     @foreach ($contractors as $contractor)
                                                        <option value="{{ $contractor->id }}" {{ $contractor->id == $contractorId ? 'selected' : '' }}>
                                                            {{ $contractor->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error("contractor_ids.{$index}") 
                                                    <span class="text-danger">{{ $message }}</span> 
                                                @enderror
                                            </td>
                                            <td>
                                                <button type="button" wire:click.prevent="removeContractor({{ $index }})" class="btn btn-danger btn-sm">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="button" wire:click.prevent="addContractor" class="btn btn-info btn-sm mt-2">
                            <i class="ri-add-line"></i> Add Contractor
                        </button>
                    </div>
                </div>
                
                

            @endif

            <div class="col-md-6 mb-3">
                <label for="specification" class="form-label fw-semibold">Specification</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="specification" id="specificationFavourable"
                        value="favourable" wire:model="specification"
                        {{ $specification === 'favourable' ? 'checked' : '' }}>
                    <label class="form-check-label" for="specificationFavourable">
                        Favourable
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="specification"
                        id="specificationNonFavourable" value="non-favourable" wire:model="specification"
                        {{ $specification === 'non-favourable' ? 'checked' : '' }}>
                    <label class="form-check-label" for="specificationNonFavourable">
                        Non-Favourable
                    </label>
                </div>
                @error('specification')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold text-danger">Management Status *</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="management_status" id="management_status_yes"
                        value="Yes" wire:model="management_status">
                    <label class="form-check-label" for="management_status_yes">
                        Yes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="management_status" id="management_status_no"
                        value="No" wire:model="management_status">
                    <label class="form-check-label" for="management_status_no">
                        No
                    </label>
                </div>
                @error('management_status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

        </div>
        <!-- Remarks -->
        <div class="mb-3">
            <label for="remark" class="form-label fw-semibold">Remarks</label>
            <textarea id="remark" wire:model="remark" class="form-control" placeholder="Enter any additional remarks"></textarea>
            @error('remark')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex justify-content-between">
            <div class="col-sm-3">
                <label for="assigned_to" class="form-label fw-semibold">Assign to Agent</label>
                <select wire:model="assigned_to" id="assigned_to" class="form-select form-select-sm">
                    <option value="">Select an Agent</option>
                    @foreach($teamAgents as $agent)
                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                    @endforeach
                </select>
                @error('assigned_to') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btn-secondary btn-sm me-2"><i class="ri-add-circle-line"></i> Create
                    Lead</button>
                <a href="{{ route('leads.index') }}" class="btn btn-danger btn-sm">Cancel</a>
            </div>
        </div>
    </form>
</div>