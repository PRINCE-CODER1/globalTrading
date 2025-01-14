<div>
    <div class="container">
        <div class="row mt-5 mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Leads</h4>
                <a href="{{ route('leads.create') }}" class="btn btn-secondary"><i
                        class="ri-add-circle-line"></i>
                    Create Lead</a>
            </div>
        </div>
    </div>
    {{-- Filter section --}}
    <div class="container my-4">
        <div class="card shadow-sm rounded bg-secondary">
            <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex flex-wrap align-items-center justify-content-start gap-3">
                    <!-- Status Filter -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark dropdown-toggle fw-bold" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter: {{ $statusFilter ?: 'All' }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" wire:click="$set('statusFilter', '')">All</a></li>
                            @foreach ($statuses as $status)
                                <li>
                                    <a class="dropdown-item" wire:click="$set('statusFilter', '{{ $status->name }}')">
                                        {{ $status->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Team Filter -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark btn-wave dropdown-toggle fw-bold" data-bs-toggle="dropdown" aria-expanded="false">
                            Teams: {{ $teamFilter ?: 'All' }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" wire:click="$set('teamFilter', '')">All</a></li>
                            @foreach ($teams as $team)
                                <li>
                                    <a class="dropdown-item" wire:click="$set('teamFilter', '{{ $team->name }}')">
                                        {{ $team->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Per Page Filter -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark btn-wave dropdown-toggle fw-bold" data-bs-toggle="dropdown" aria-expanded="false">
                            Per Page: {{ $perPage }}
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ([2, 5, 10, 20] as $size)
                                <li>
                                    <a class="dropdown-item" href="#" wire:click.prevent="updatePerPage({{ $size }})">
                                        {{ $size }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
               <!-- Export Lead -->
                <div class="d-flex justify-content-between gap-3 mb-1 position-relative align-items-center">
                    <!-- Export as Excel -->
                    <button 
                        wire:click="exportLeads('xlsx')" 
                        wire:loading.attr="disabled" 
                        class="btn btn-dark btn-wave fw-bold d-flex align-items-center">
                        <i class="ri-file-excel-2-line me-1"></i> Export as Excel
                    </button>
                    
                    <!-- Export as CSV -->
                    <button 
                        wire:click="exportLeads('csv')" 
                        wire:loading.attr="disabled" 
                        class="btn btn-dark btn-wave fw-bold d-flex align-items-center">
                        <i class="ri-export-line me-1"></i> Export as CSV
                    </button>
                    
                    <!-- Loading Spinner -->
                    <div wire:loading class="spinner-border text-dark ms-2" role="status" style="width: 1.5rem; height: 1.5rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>



                {{-- Search and Filters Row --}}
                <div class="col-md-12 mt-3">
                    <div class=" d-flex align-items-center justify-content-between">
                        <div class="d-flex gap-3 ">
                            <!-- Search Input -->
                            <div>
                                <input wire:model.live="search" type="text" id="search" class="form-control fw-bold" placeholder="Search">
                            </div>
                            <!-- Date Filters -->
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <label for="" class="text-white fw-bold">Start</label>
                                <input wire:model.live="startDate" type="date" class="form-control fw-bold">
                            </div>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <label for="" class="text-white fw-bold">End</label>
                                <input wire:model.live="endDate" type="date" class="form-control fw-bold">
                            </div>
                        </div>
                        {{-- Reset Filters --}}
                        <div class="d-flex justify-content-end">
                            <button wire:click="resetFilters" class="btn btn-danger fw-bold">
                                <i class="bi bi-arrow-clockwise"></i> Reset Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div>

                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                {{-- @if ($leads->count()) --}}
                                <table class="table table-bordered text-nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <input type="checkbox" wire:model.live="selectAll">
                                            </th>
                                            <th>Reference Id</th>
                                            <th>Customer</th>
                                            <th>Customer Users</th>
                                            <th>Status</th>
                                            <th>Source</th>
                                            <th>Series</th>
                                            <th>Segment</th>
                                            <th>Sub-Segment</th>
                                            <th>Expected Date</th>
                                            <th>Amount</th>
                                            <th>Next Follow Up Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($leads as $lead)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" wire:model.live="selectedLeads"
                                                        value="{{ $lead->id }}">
                                                </td>
                                                <td>{{ $lead->reference_id }}</td>
                                                <td>{{ $lead->customer->name ?? 'N/A' }}</td>
                                                <td>{{ $lead->customerUser->name ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge"
                                                        style="background-color: {{ $lead->leadStatus->color }}; color: #fff;">
                                                        {{ $lead->leadStatus->name ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>{{ $lead->leadSource->name ?? 'N/A' }}</td>
                                                <td>{{ $lead->Series->name ?? 'N/A' }}</td>
                                                <td>{{ $lead->segment->name ?? 'N/A' }}</td>
                                                <td>{{ $lead->subSegment->name ?? 'N/A' }}</td>
                                                <td>{{ $lead->expected_date }}</td>
                                                <td>{{ $lead->amount }}</td>
                                                <td>{{ $lead->remarks->last()?->date ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('leads.edit', $lead->id) }}"
                                                        class="btn btn-info btn-sm text-white"><i
                                                            class="ri-edit-line"></i> view</a>
                                                    <button class="btn btn-link text-danger fs-14 lh-1 p-0"
                                                        data-bs-toggle="modal" data-bs-target="#deleteSegmentModal"
                                                        wire:click="confirmDelete({{ $lead->id }})">
                                                        <i class="ri-delete-bin-5-line"></i>
                                                    </button>
                                                    <!-- Delete Modal -->
                                                    <div wire:ignore.self class="modal fade" data-bs-dismiss="modal"
                                                        id="deleteSegmentModal" tabindex="-1"
                                                        aria-labelledby="deleteSegmentModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteSegmentModalLabel">Delete</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <form wire:submit.prevent="deleteConfirmed">
                                                                    <div class="modal-body">
                                                                        <h6>Are you sure you want to delete this Lead?
                                                                        </h6>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Delete</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">No Leads found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $leads->links('custom-pagination-links') }}
                                </div>
                                {{-- @endif                               --}}
                            </div>
                            <!-- Bulk Delete Button -->
                            <div class="mt-2">
                                @if ($selectedLeads)
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#bulkDeleteConfirmationModal">Delete</button>
                                    <!-- Bulk Delete Confirmation Modal -->
                                    <div wire:ignore.self class="modal fade" data-bs-dismiss="modal"
                                        id="bulkDeleteConfirmationModal" tabindex="-1"
                                        aria-labelledby="bulkDeleteConfirmationModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="bulkDeleteConfirmationModalLabel">
                                                        Confirm Bulk Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete the selected Leads?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-danger"
                                                        wire:click="bulkDelete">Confirm Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>