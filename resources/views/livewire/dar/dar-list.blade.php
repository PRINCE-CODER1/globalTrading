<div>
    <div class="container">
        <div class="row mt-5 mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h4>Daily Activity Reports (DAR)</h4>
                <a href="{{ route('daily-report.create') }}" class="btn btn-secondary"><i class="ri-add-circle-line"></i> Create Daily Activity Report</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Per Page: {{ $perPage }}
                    </button>
                    <ul class="dropdown-menu">
                        @foreach ([2, 5, 10, 20] as $size)
                            <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage({{ $size }})">{{ $size }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Search Input -->
                <div class="d-flex align-items-center">
                    <div class="col-auto">
                        <input wire:model.live="search" type="text" id="search" class="form-control" placeholder="Search">
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
                            <table class="table text-nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <input type="checkbox" wire:model.live="selectAll">
                                        </th>
                                        <th scope="col" wire:click="setSortBy('customer_id')">Customer
                                            @if ($sortBy === 'customer_id')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                            @else
                                                <i class="ri-expand-up-down-fill"></i>
                                            @endif
                                        </th>
                                        <th scope="col" wire:click="setSortBy('pov_id')">Purpose
                                            @if ($sortBy === 'pov_id')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                            @else
                                                <i class="ri-expand-up-down-fill"></i>
                                            @endif
                                        </th>
                                        <th scope="col" wire:click="setSortBy('remarks')">Remarks
                                            @if ($sortBy === 'remarks')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                            @else
                                                <i class="ri-expand-up-down-fill"></i>
                                            @endif
                                        </th>
                                        <th scope="col" wire:click="setSortBy('status')">Status
                                            @if ($sortBy === 'status')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                            @else
                                                <i class="ri-expand-up-down-fill"></i>
                                            @endif
                                        </th>
                                        <th scope="col" wire:click="setSortBy('user_id')">Visit Date
                                            @if ($sortBy === 'user_id')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                            @else
                                                <i class="ri-expand-up-down-fill"></i>
                                            @endif
                                        </th>
                                        <th scope="col" wire:click="setSortBy('created_at')">Created At
                                            @if ($sortBy === 'created_at')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                            @else
                                                <i class="ri-expand-up-down-fill"></i>
                                            @endif
                                        </th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dar as $report)
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model.live="selectedDar" value="{{ $report->dar_id }}">
                                            </td>
                                            <td>{{ $report->customer->name }}</td>
                                            <td>{{ $report->purposeOfVisit->visitor_name }}</td>
                                            <td>{{ $report->remarks }}</td>
                                            <td>{{ $report->status == 1 ? 'Open' : 'Close' }}</td>
                                            <td>{{ $report->date->format('Y-m-d ')  }}</td>
                                            <td>{{ $report->created_at->format('Y-m-d ') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('daily-report.edit', $report->dar_id) }}" class="btn btn-link text-info"><i class="ri-edit-line"></i></a>
                                                    <button class="btn btn-link text-danger fs-14 lh-1 p-0" data-bs-toggle="modal" data-bs-target="#deleteModal" wire:click="confirmDelete({{ $report->dar_id }})">
                                                        <i class="ri-delete-bin-5-line"></i>
                                                    </button>                                                    
                                                    <!-- Bulk Delete Confirmation Modal -->
                                                    <div wire:ignore.self data-bs-dismiss="modal"  class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="bulkDeleteConfirmationModalLabel">Confirm Bulk Delete</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete the selected DAR?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="button" class="btn btn-danger" wire:click="confirmBulkDelete">Confirm Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No records found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Bulk Delete Button -->
                        <div class="mt-2">
                            @if($selectedDar && count($selectedDar) > 0)
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#bulkDeleteConfirmationModal">Delete Selected</button>
                            @endif
                        </div>

                        <!-- Bulk Delete Confirmation Modal -->
                        <div wire:ignore.self  class="modal fade" id="bulkDeleteConfirmationModal" tabindex="-1" aria-labelledby="bulkDeleteConfirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="bulkDeleteConfirmationModalLabel">Confirm Bulk Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the selected DARs?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-danger" wire:click="confirmBulkDelete">Confirm Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-3">
                            {{ $dar->links('custom-pagination-links') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
