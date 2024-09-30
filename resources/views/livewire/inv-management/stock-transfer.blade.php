<div>
    <div class="container">
        <div class="row mt-5 mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Stock Transfer</h4>
                <a href="{{ route('stock_transfer.create') }}" class="btn btn-secondary"><i class="me-2 ri-add-circle-line"></i>Create Sales</a>
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
    
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <input wire:model.live.debounce.300ms="searchTerm" type="text" id="search" class="form-control" placeholder="Search">
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
                            <div class="table-responsive">
                                <table class="table table-nowrap table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" wire:model.live="selectAll"></th>
                                            <th scope="col">Stock Transfer No.</th>
                                            <th scope="col">Stock Transfer Date</th>
                                            <th scope="col">Created By</th>
                                            <th scope="col">Created On</th>
                                            <th scope="col">Product Detail</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($stockTransfers as $transfer)
                                            <tr>
                                                <td><input type="checkbox" wire:model.live="selectedStock" value="{{ $transfer->id }}"></td>
                                                <td>{{ $transfer->stock_transfer_no }}</td>
                                                <td>{{ \Carbon\Carbon::parse($transfer->stock_transfer_date)->format('d/m/Y') }}</td>
                                                <td>{{ $transfer->user->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($transfer->created_at)->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i> View Details</button>
                                                </td>
                                                <td>
                                                    <a href="{{ route('stock_transfer.edit', $transfer->id) }}" class="btn btn-link text-info"><i class="ri-edit-line"></i></a>
                                                    <button wire:click="confirmDelete({{ $transfer->id }})" class="btn btn-link text-danger fs-14 lh-1 p-0" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="ri-delete-bin-5-line"></i></button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No stock transfers found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- Bulk Delete Button -->
                            @if ($selectedStock)
                            <button class="btn btn-outline-danger mt-1" data-bs-toggle="modal" data-bs-target="#bulkDeleteConfirmationModal">Delete</button>
                            @endif

                            <div class="d-flex justify-content-center">
                                {{ $stockTransfers->links('custom-pagination-links') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Delete Modal -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Stock Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Stock Transfer?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteConfirmed" data-bs-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Delete Confirmation Modal -->
    <div wire:ignore.self class="modal fade" id="bulkDeleteConfirmationModal" tabindex="-1" aria-labelledby="bulkDeleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkDeleteConfirmationModalLabel">Confirm Bulk Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the selected Stock Transfers?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="bulkDelete" data-bs-dismiss="modal">Delete All</button>
                </div>
            </div>
        </div>
    </div>
</div>
