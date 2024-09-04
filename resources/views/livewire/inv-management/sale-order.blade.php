<div>
    <div class="container">
        <div class="row mt-5 mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Sales Orders</h4>
                <a href="{{ route('sale_orders.create') }}" class="btn btn-secondary"><i class="me-2 ri-add-circle-line"></i>Create Sale Order</a>
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
                        <input wire:model.live.debounce.300ms="search" type="text" id="search" class="form-control" placeholder="Search">
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
                                <table class="table text-nowrap table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" wire:model.live="selectAll"></th>
                                            <th>Sale Order No</th>
                                            <th>Sale Order Date</th>
                                            <th>Customer Name</th>
                                            <th>Net Amount</th>
                                            <th>Created By</th>
                                            <th>Created On</th>
                                            <th>Product Details</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($saleOrders as $saleOrder)
                                        <tr>
                                            <td><input type="checkbox" wire:model.live="selectedOrders" value="{{ $saleOrder->id }}"></td>
                                            <td>{{ $saleOrder->sale_order_no }}</td>
                                            <td>{{ \Carbon\Carbon::parse($saleOrder->date)->format('d-m-Y') }}</td>
                                            <td>{{ $saleOrder->customer->name ?? 'N/A' }}</td>
                                            <td>{{ number_format($saleOrder->items->sum('sub_total'), 2) }}</td>
                                            <td>{{ $saleOrder->user->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($saleOrder->created_at)->format('d-m-Y') }}</td>
                                            <td>
                                                <ul>
                                                    @foreach($saleOrder->items as $item)
                                                    <li>{{ $item->product->name }} (Qty: {{ $item->quantity }}, Price: {{ number_format($item->price, 2) }})</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <a href="{{ route('sale_orders.edit', $saleOrder->id) }}" class="btn btn-link text-info"><i class="ri-edit-line"></i></a>
                                                <button wire:click="confirmDelete({{ $saleOrder->id }})" class="btn btn-link text-danger fs-14 lh-1 p-0" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="ri-delete-bin-5-line"></i></button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No sale orders found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- Bulk Delete Button -->
                            @if ($selectedOrders)
                                <button class="btn btn-outline-danger mt-1" data-bs-toggle="modal" data-bs-target="#bulkDeleteConfirmationModal">Delete</button>
                            @endif
                            <!-- Pagination Links -->
                            <div class="mt-3">
                                {{ $saleOrders->links('custom-pagination-links') }}
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Modal -->
    <div wire:ignore.self class="modal fade" data-bs-dismiss="modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Sale Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Sale Order?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteConfirmed">Delete</button>
                </div>
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
                    Are you sure you want to delete the selected Sale Orders?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="bulkDelete">Delete All</button>
                </div>
            </div>
        </div>
    </div>
 
</div>
