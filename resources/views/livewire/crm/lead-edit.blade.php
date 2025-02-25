<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-2 d-flex align-items-center justify-content-between mb-2">
                <h5 class="mb-0 ">Edit Lead : <span class="text-secondary"> {{ $lead->id }}</span>
                </h5>
                @if (auth()->user()->hasRole('Agent'))
                    <a href="{{ route('leads.index') }}" class="btn btn-secondary btn-wave float-end">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                @endif

            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style2 mb-0    ">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0);" class="text-muted"><i
                                            class="bi bi-house-door me-1 fs-15"></i>
                                        Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('leads.index') }}" class="text-muted"><i
                                            class="bi bi-clipboard me-1 fs-15"></i> Leads</a>
                                </li>
                                <li class="breadcrumb-item active text-muted" aria-current="page">Edit Lead</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
    <div class="container mb-5">
        <div class="row">
            <!-- Lead Information Card -->
            <div class="col-md-12">
                <div class="bg-white p-4">
                    <div class="card-body">
                        <!-- Form -->
                        <form wire:submit.prevent="save">
                            <div class="row justify-content-between mb-4">
                                <!-- Lead ID -->
                                <div class="">
                                    {{-- <label for="lead_id" class="form-label fw-bold small">Lead ID</label> --}}
                                    <input type="hidden" id="lead_id" class="form-control form-control-sm"
                                        value="{{ $lead->id }}" readonly>
                                </div>

                                <!-- Lead Status -->
                                <div class="col-md-3">

                                    @if ($lead_status_id)
                                        @php
                                            $selectedStatus = $leadStatuses->where('id', $lead_status_id)->first();
                                        @endphp
                                        @if ($selectedStatus && $selectedStatus->color)
                                            <span class="badge fs-15"
                                                style="background-color: {{ $selectedStatus->color }}; color: #fff;">
                                                {{ $selectedStatus->name }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">No Color Available</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">No Status Selected</span>
                                    @endif
                                </div>
                                <div class="col-md-3 text-end">
                                    <label class="fw-bold small">Created At :</label>
                                    <small> {{ $lead->created_at }}</small>
                                </div>
                            </div>
                            <style>
                                .form-select {
                                    border: 1px solid #dddddd
                                }
                            </style>
                            <div class="row g-2 mb-4">
                                <div class="col-md-4">
                                    <label for="cust" class="form-label fw-semibold">Customer</label>
                                    <input type="text" name="customer_id" class="form-control form-control-sm @error('customer_id') is-invalid @enderror" id="name" placeholder="cusomter name" value="{{ $lead->customer->name }}" required disabled>
                                        @error('customer_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                </div>    
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="cust_sup_user" class="form-label fw-semibold">Select Customer User</label>
                                        <select wire:model="customer_supplier_user_id" class="form-select form-select-sm">
                                            <option value="">Select User</option>
                                            @foreach($selectedCustomerUsers as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('customer_supplier_user_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <!-- Lead Status Dropdown -->
                                <div class="col-md-4 ">
                                    <label for="lead_status_id" class="form-label text-muted small">Lead Status</label>
                                    <select id="lead_status_id" wire:model.live="lead_status_id"
                                        class="form-select form-select-sm">
                                        <option value="">Select Status</option>
                                        @foreach ($leadStatuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('lead_status_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Segment -->
                                <div class="col-md-4">
                                    <label for="segment_id" class="form-label text-muted small">Segment</label>
                                    <select id="segment_id" wire:model.live="segment_id"
                                        class="form-select form-select-sm">
                                        <option value="">Select Segment</option>
                                        @foreach ($segments as $segment)
                                            <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('segment_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Sub-Segment -->
                                <div class="col-md-4">
                                    <label for="sub_segment_id" class="form-label text-muted small">Sub-Segment</label>
                                    <select id="sub_segment_id" wire:model="sub_segment_id"
                                        class="form-select form-select-sm">
                                        <option value="">Select Sub-Segment</option>
                                        @foreach ($subSegments as $subSegment)
                                            <option value="{{ $subSegment->id }}">{{ $subSegment->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sub_segment_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-2 mb-4">

                                <!-- Lead Source -->
                                <div class="col-md-4 mb-3">
                                    <label for="lead_source_id" class="form-label text-muted small">Lead Source</label>
                                    <select id="lead_source_id" wire:model="lead_source_id"
                                        class="form-select form-select-sm">
                                        <option value="">Select Source</option>
                                        @foreach ($leadSources as $source)
                                            <option value="{{ $source->id }}">{{ $source->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('lead_source_id')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Expected Date -->
                                <div class="col-md-4">
                                    <label for="expected_date" class="form-label text-muted small">Expected Date</label>
                                    <input type="date" id="expected_date" wire:model="expected_date"
                                        class="form-control form-control-sm">
                                    @error('expected_date')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Stock Category Selection -->
                                <div class="col-md-4">
                                    <label for="category_id" class="form-label text-muted small">Stock Category</label>
                                    <select wire:model.live="category_id" id="category_id" class="form-select">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Child Category Selection (Dependent on Stock Category) -->
                                <div class="col-md-4">
                                    <label for="child_category_id" class="form-label text-muted small">Child
                                        Category</label>
                                    <select wire:model.live="child_category_id" id="child_category_id"
                                        class="form-select" {{ empty($childCategories) ? 'disabled' : '' }}>
                                        <option value="">Select Child Category</option>
                                        @foreach ($childCategories as $childCategory)
                                            <option value="{{ $childCategory->id }}">{{ $childCategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('child_category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="series" class="form-label text-muted small">Series</label>
                                    <select id="series" wire:model="series" class="form-select form-select-sm">
                                        <option value="">Select series</option>
                                        @if ($seriesList->isEmpty())
                                            <option value="">No series available</option>
                                        @else
                                            @foreach ($seriesList as $singleSeries)
                                                <option value="{{ $singleSeries->id }}">{{ $singleSeries->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('series')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="series" class="form-label text-muted small">Lead Type</label>
                                    <select wire:model.live="lead_type_id" class="form-select form-select-sm">
                                        <option value="">Select Lead Type</option>
                                        @foreach($leadTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('lead_type_id') <span class="text-danger">{{ $message }}</span> @enderror                                    
                                </div>
                                <div class="col-md-4">
                                    <label for="application" class="form-label text-muted small">Application</label>
                                    <select wire:model="application_id" class="form-select form-select-sm">
                                        <option value="">Select Application</option>
                                        @foreach($applications as $application)
                                            <option value="{{ $application->id }}">{{ $application->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('application_id') <span class="text-danger">{{ $message }}</span> @enderror                                    
                                </div>
                                <div class="col-md-4">
                                    <label for="amount" class="form-label fw-semibold">Amount</label>
                                    <input type="text" wire:model="amount" id="amount" class="form-control form-control-sm" placeholder="enter amount" />
                                    @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="specification" class="form-label fw-semibold">Specification</label>
                                    <div class="d-flex gap-3 justify-content-start align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="specification" id="specificationFavourable" value="favourable"
                                                   wire:model="specification">
                                            <label class="form-check-label" for="specificationFavourable">
                                                Favourable
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="specification" id="specificationNonFavourable" value="non-favourable"
                                                   wire:model="specification">
                                            <label class="form-check-label" for="specificationNonFavourable">
                                                Non-Favourable
                                            </label>
                                        </div>
                                    </div>
                                    @error('specification')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-danger">Management Status *</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="management_status" id="management_status_yes"
                                        value="Yes" wire:model="management_status" required>
                                    <label class="form-check-label" for="management_status_yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="management_status" id="management_status_no"
                                        value="No" wire:model="management_status" required>
                                    <label class="form-check-label" for="management_status_no">
                                        No
                                    </label>
                                </div>
                                @error('management_status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                @if($showContractOptions)
                                {{-- <div class="mb-3">
                                    <label for="contractor_id" class="form-label text-muted small">Contractor</label>
                                    <select wire:model="contractor_ids" id="contractor_ids"  class="form-select form-select-sm" multiple>
                                        <option value="">Select Contractor</option>
                                        @foreach($contractors as $contractor)
                                            <option value="{{ $contractor->id }}">{{ $contractor->name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="">
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
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between mt-3">
                                <button type="submit" class="btn btn-secondary btn-md"><i
                                        class="ri-save-3-line"></i> Update</button>
                                @if (auth()->user()->hasRole('Agent'))
                                    <a href="{{ route('leads.index') }}" class="btn btn-outline-danger btn-sm d-flex justify-content-center align-items-center ">
                                        <i class="bi bi-arrow-left me-1"></i> Back
                                    </a>
                                @endif
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#assignAgentModal">
                                    <i class="ri-links-line me-1"></i> Assign to Agent
                                </button>
                            </div>
                             
                            <!-- Modal for assigning the lead to an agent -->
                            <div wire:ignore class="modal fade"  id="assignAgentModal" tabindex="-1" aria-labelledby="assignAgentModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="assignAgentModalLabel">Assign Lead to an Agent</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Select an agent to assign this lead. Leave unassigned if you do not want to assign:</p>
                                            
                                            <!-- Dropdown to select an agent -->
                                            <select wire:model="assigned_to" class="form-control">
                                                <option value="">Do not assign</option>
                                                @foreach ($teamAgents as $agent)
                                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('assigned_to') <span class="text-danger">{{ $message }}</span> @enderror
                                            <p class="mt-2"><strong>Note :</strong><span class="text-danger"> Once you assign this lead to your team mate, lead will be transferred and it will not be visible in your panel.</span></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" wire:click="$set('assigned_to', '')" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-secondary" wire:click="assignAgent" data-bs-dismiss="modal">Assign</button>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-md-12 ">
                <ul class="nav nav-tabs tab-style-2 nav-justified d-sm-flex d-block bg-white" id="myTab1"
                    role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="order-tab" data-bs-toggle="tab"
                            data-bs-target="#order-tab-pane" type="button" role="tab"
                            aria-controls="home-tab-pane" aria-selected="true"><i
                                class="ri-gift-line me-1 align-middle"></i>Lead Information</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="confirmed-tab" data-bs-toggle="tab"
                            data-bs-target="#confirm-tab-pane" type="button" role="tab"
                            aria-controls="profile-tab-pane" aria-selected="false"><i
                                class="ri-check-double-line me-1 align-middle"></i>Follow Up</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="shipped-tab" data-bs-toggle="tab"
                            data-bs-target="#shipped-tab-pane" type="button" role="tab"
                            aria-controls="contact-tab-pane" aria-selected="false"><i
                                class="ri-file-3-fill"></i>Files</button>
                    </li>
                </ul>
                <!-- Nav tabs -->
                <style>
                    .nav-tabs .nav-link.active {
                        background-color: #45D65B;
                        /* Green background color */
                        color: white;
                        /* Text color for better contrast */
                    }

                    .nav-tabs .nav-link {
                        color: #45D65B;
                        /* Default text color for tabs */
                    }

                    .nav-tabs .nav-link:hover {
                        background-color: rgba(40, 217, 167, 0.1);
                        /* Light green on hover */
                    }

                    .tab-style-2 .nav-item .nav-link.active i {
                        background-color: #45D65B;
                        color: white;
                    }

                    .tab-style-2 .nav-item .nav-link.active {
                        background-color: transparent;
                        position: relative;
                        border: 0;
                        color: #45D65B;
                    }

                    .tab-style-2 .nav-item .nav-link.active:before {
                        content: "";
                        position: absolute;
                        inset-inline-start: 0;
                        inset-inline-end: 0;
                        inset-block-end: 0;
                        width: 100%;
                        height: 0.175rem;
                        background-color: #45D65B;
                        border-radius: 50px;
                    }
                </style>

                <div class="tab-content bg-white p-3" id="myTabContent">
                    <!-- Lead Information Tab -->
                    <div class="tab-pane fade text-muted " id="order-tab-pane" role="tabpanel"
                        aria-labelledby="home-tab" tabindex="0">
                        <div class="card  shadow-sm mb-4">
                            <div
                                class="card-header bg-dark text-white py-2 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold"><span><i class="ri-information-line"></i> Lead Information
                                        :</span></h6>
                                <i class="ri-information-line fs-5"></i>
                            </div>
                            <div class="card-body">
                                <!-- Lead Created By -->
                                <div class="mb-3">
                                    <h6 class="text-muted fw-bold"><i class="ri-user-3-line me-2"></i>Created By:</h6>
                                    <p class="small mb-0">{{ $lead->user->name ?? 'Unknown' }}</p>
                                </div>

                                <!-- Lead Assigned To -->
                                <div class="mb-3">
                                    <h6 class="text-muted fw-bold"><i class="ri-user-settings-line me-2"></i> Team
                                        Assigned To:</h6>
                                    <p class="small">
                                        @if ($lead->assignedAgent)
                                            @if ($lead->assignedAgentTeams()->isNotEmpty())
                                                @foreach ($lead->assignedAgentTeams() as $team)
                                                    <span class="badge bg-dark me-1">{{ $team->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-secondary small">No teams assigned to the
                                                    agent</span>
                                            @endif
                                        @else
                                            @if ($lead->user_id === Auth::id())
                                                <span class="badge bg-primary">Lead created by manager</span>
                                                @if ($lead->managerTeams()->isNotEmpty())
                                                    @foreach ($lead->managerTeams() as $team)
                                                        <span
                                                            class="badge bg-secondary me-1">{{ $team->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-secondary small">No teams assigned to the
                                                        manager</span>
                                                @endif
                                            @else
                                                <span class="text-secondary small">No agent assigned</span>
                                            @endif
                                        @endif
                                    </p>
                                </div>

                                <!-- Lead Assign History -->
                                <div class="mb-3">
                                    <h6 class="text-muted fw-bold"><i class="ri-time-line me-2"></i>Assign History:
                                    </h6>
                                    <ul class="list-unstyled small">
                                        @forelse($lead->remarks as $remark)
                                            <li class="mb-1"><i
                                                    class="ri-user-line me-1"></i>{{ $remark->user->name ?? 'Unknown' }}
                                                - <span
                                                    class="text-muted">{{ $remark->created_at->format('d-m-Y H:i') }}</span>
                                            </li>
                                        @empty
                                            <p class="text-secondary small">No history available.</p>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Follow Up Tab -->
                    <div class="tab-pane fade show active text-muted " id="confirm-tab-pane" role="tabpanel"
                        aria-labelledby="profile-tab" tabindex="0">
                        <h6 class="fw-bold"><span><i class="ri-chat-4-line"></i> Follow up :</span></h6>
                        <div class=" mt-3 ">

                            <form wire:submit.prevent="addRemark" enctype="multipart/form-data">
                                <div class="mb-4">
                                    <textarea id="remark" wire:model="remark" class="form-control" rows="3" placeholder="Add a new remark"
                                        required></textarea>
                                    @error('remark')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="date" class="form-label text-muted small">Next Follow Up Date</label>
                                    <input type="date" id="date" class="form-control" wire:model="date">
                                    @error('date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <button type="submit" class="btn btn-secondary mb-3">
                                    <i class="ri-links-line"></i> Add Remark
                                </button>
                            </form>

                            @if ($remarks->isNotEmpty())
                                <div class="table-responsive mt-4">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>User</th>
                                                <th>Remark</th>
                                                <th>created_at</th>
                                                <th>Next Follow Up Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($remarks as $remark)
                                                <tr>
                                                    <td>{{ $remark->user->name ?? 'Unknown User' }}</td>
                                                    <td>{{ $remark->remark }}</td>
                                                    <td>{{ $remark->created_at->format('d-m-Y') }}</td>
                                                    <td>{{ $remark->date ? \Carbon\Carbon::parse($remark->date)->format('d-m-Y') : 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No remarks available.</p>
                            @endif

                        </div>
                    </div>

                    <!-- Images Tab -->
                    <div class="tab-pane fade text-muted " id="shipped-tab-pane" role="tabpanel"
                        aria-labelledby="contact-tab" tabindex="0">
                        <div class="card-body">
                            <form wire:submit.prevent="addRemark" enctype="multipart/form-data">

                                <div class="mb-4">
                                    <label for="image" class="form-label fw-bold">Upload Image
                                        (Optional)</label>
                                    <input type="file" id="image" wire:model="image" class="form-control">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-secondary mb-3">
                                    <i class="ri-links-line"></i> Add Files
                                </button>
                            </form>
                            @if ($remarks->isNotEmpty())
                                <h6 class="fw-bold"><span><i class="ri-chat-upload-line"></i> Uploaded Images :</span>
                                </h6>
                                
                                <div class="row mt-2">
                                    @foreach ($remarks->sortByDesc('created_at') as $remark)
                                        <!-- Sort remarks by creation date -->
                                        @if ($remark->image)
                                            <div class="col-md-3 mb-3">
                                                <div
                                                    class="card shadow-sm d-flex justify-content-center align-items-center p-4">
                                                    <div class="position-relative"
                                                        style="width: 200px; height: 200px;">
                                                        <span>
                                                            <img src="{{ asset('storage/' . $remark->image) }}"
                                                                style="object-fit: cover; width: 100%; height: 100%; border-radius: 50%;"
                                                                alt="Remark Image" class="img-fluid"
                                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                onclick="showImage('{{ asset('storage/' . $remark->image) }}')">
                                                            <!-- New Indicator -->
                                                            <!-- If uploaded within the last week -->
                                                            @if ($remark->created_at->diffInDays() <= 7)
                                                                <span
                                                                    class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                                                                </span>
                                                            @else
                                                                <!-- If older than one week -->
                                                                <span
                                                                    class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                                                </span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="card-body text-center">
                                                        <h6 class="card-title">
                                                            {{ $remark->user->name ?? 'Unknown User' }}</h6>
                                                        <p class="card-text text-muted">
                                                            {{ $remark->created_at->format('d M Y') }}</p>
                                                        <p class="small text-muted">{{ $remark->remark }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <!-- Modal for Image Display -->
                                <div wire:ignore.self id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <img id="modalImage" src="" alt="Remark Image"
                                                    class="img-fluid rounded" style="max-width: 100%; height: auto;">
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-dark rounded-pill"
                                                    data-bs-dismiss="modal"><i class="ri-close-line"></i>
                                                    Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted">No images available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Script for Dynamic Modal Image -->
        <script>
            function showImage(imageUrl) {
                document.getElementById('modalImage').src = imageUrl;
            }
        </script>

    </div>
</div>
