<div>
    <div class="container mt-5 mb-3">
        <div class="d-flex justify-content-between">
            <h4 class="mb-0">Customer/Supplier List</h4>
            {{-- <a href="{{ route('admin.customer-supplier.customer-supplier.create') }}" class="btn btn-secondary"><i class="ri-add-circle-line"></i> Create</a> --}}
            @php
                $route = auth()->user()->hasRole('Super Admin') 
                    ? 'admin.customer-supplier.customer-supplier.create' 
                    : 'manager.customer-supplier.customer-supplier.create';
            @endphp
            <a href="{{ route($route) }}" class="btn btn-outline-secondary">
                <i class="bi bi-chevron-left me-1"></i> Create
            </a>
        </div>
    </div>

    <div class="container">     
        <div class="row mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Per Page Dropdown -->
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
                    {{-- <div class="col-auto d-none d-md-block">
                        <label for="search" class="form-label d-none">Search</label>
                    </div> --}}
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
                                        <th scope="col" wire:click="setSortBy('name')">
                                            Name
                                            @if ($sortBy === 'name')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                            @else
                                                <i class="ri-expand-up-down-fill"></i>
                                            @endif
                                        </th>
                                        <th scope="col">Mobile No</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">State</th>
                                        <th scope="col">City</th>
                                        <th scope="col" wire:click="setSortBy('created_at')">
                                            Created By
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
                                        <th scope="col">IP Address</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customerSuppliers as $customerSupplier)
                                        <tr wire:key="{{ $customerSupplier->id }}">
                                            <td>
                                                <input type="checkbox" wire:model.live="selectedCustomerSuppliers" value="{{ $customerSupplier->id }}">
                                            </td>
                                            <td>{{ $customerSupplier->name }}</td>
                                            <td>{{ $customerSupplier->mobile_no }}</td>
                                            <td>{{ $customerSupplier->country }}</td>
                                            <td>{{ $customerSupplier->state }}</td>
                                            <td>{{ $customerSupplier->city }}</td>
                                            <td>{{ $customerSupplier->user->name }}</td>
                                            <td>{{ $customerSupplier->ip_address }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    @php
                                                    $route = auth()->user()->hasRole('Super Admin') 
                                                        ? 'admin.customer-supplier.customer-supplier.edit' 
                                                        : 'manager.customer-supplier.customer-supplier.edit';
                                                    @endphp
                                                    <a href="{{ route($route, $customerSupplier->id) }}" class="btn btn-link text-info"><i class="ri-edit-line"></i></a>
                                                    <button class="btn btn-link text-danger fs-14 lh-1 p-0" data-bs-toggle="modal" data-bs-target="#deleteSegmentModal" wire:click="confirmDelete({{ $customerSupplier->id }})"><i class="ri-delete-bin-5-line"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No Records Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Bulk Delete Button -->
                        <div class="mt-2">
                            @if($selectedCustomerSuppliers)
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#bulkDeleteConfirmationModal">Delete</button>
                            @endif
                        </div>

                        <!-- Pagination -->
                        <div class="mb-3">
                            {{ $customerSuppliers->links('custom-pagination-links') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div wire:ignore.self class="modal fade" data-bs-dismiss="modal" id="deleteSegmentModal" tabindex="-1" aria-labelledby="deleteSegmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSegmentModalLabel">Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="deleteConfirmed">
                    <div class="modal-body">
                        <h6>Are you sure you want to delete this record?</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Delete Confirmation Modal -->
    <div wire:ignore.self class="modal fade" data-bs-dismiss="modal" id="bulkDeleteConfirmationModal" tabindex="-1" aria-labelledby="bulkDeleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkDeleteConfirmationModalLabel">Confirm Bulk Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected records?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="bulkDelete">Confirm Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
