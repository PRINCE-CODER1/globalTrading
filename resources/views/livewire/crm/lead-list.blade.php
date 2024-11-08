<div>
    <div class="container">
        <div class="row mt-5 mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Leads</h4>
                <a href="{{ route('agent.leads.create') }}" class="btn btn-secondary"><i
                        class="ri-add-circle-line"></i>
                    Create Lead</a>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Per Page: {{ $perPage }}
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ([2, 5, 10, 20] as $size)
                                <li><a class="dropdown-item" href="#"
                                        wire:click.prevent="updatePerPage({{ $size }})">{{ $size }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Filter Dropdown -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Filter: {{ $statusFilter ?: 'All' }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" wire:click="$set('statusFilter', '')">All</a></li>
                            @foreach ($statuses as $status)
                                <li><a class="dropdown-item"
                                        wire:click="$set('statusFilter', '{{ $status->name }}')">{{ $status->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Search Input -->
                <div class="d-flex align-items-center">
                    <div class="col-auto">
                        <input wire:model.live="search" type="text" id="search" class="form-control"
                            placeholder="Search">
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
                                            <th>Customer</th>
                                            <th>Status</th>
                                            <th>Source</th>
                                            <th>Segment</th>
                                            <th>Sub-Segment</th>
                                            <th>Expected Date</th>
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
                                                <td>{{ $lead->customer->name ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge"
                                                        style="background-color: {{ $lead->leadStatus->color }}; color: #fff;">
                                                        {{ $lead->leadStatus->name ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>{{ $lead->leadSource->name ?? 'N/A' }}</td>
                                                <td>{{ $lead->segment->name ?? 'N/A' }}</td>
                                                <td>{{ $lead->subSegment->name ?? 'N/A' }}</td>
                                                <td>{{ $lead->expected_date }}</td>
                                                <td>
                                                    <a href="{{ route('agent.leads.edit', $lead->id) }}"
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