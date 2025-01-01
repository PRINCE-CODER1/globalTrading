<div>
    <div class="container mt-5 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Purchase</h4>
            <a href="{{ route('purchase.create') }}" class="btn btn-secondary">
                <i class="me-2 ri-add-circle-line"></i>Create Purchase
            </a>
        </div>
    </div>

    <div class="container mb-3">
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

            <div class="d-flex align-items-center">
                <input wire:model.live.debounce.300ms="search" type="text" id="search" class="form-control" placeholder="Search">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" wire:model.live="selectAll"></th>
                                        {{-- <th scope="col">Order No</th> --}}
                                        <th scope="col">Order Date</th>
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Sup Order No</th>
                                        <th scope="col">Created On</th>
                                        <th scope="col">Product Detail</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($purchases as $purchase)
                                        <tr wire:key="purchase-{{ $purchase->id }}">
                                            <td><input type="checkbox" wire:model.live="selectedPurchases" value="{{ $purchase->id }}"></td>
                                            {{-- <td>{{ $purchase->purchase_no }}</td> --}}
                                            <td>{{ $purchase->purchase_date ? \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') : 'N/A' }}</td>
                                            <td>{{ $purchase->supplier->name ?? 'N/A' }}</td>
                                            <td>{{ $purchase->user->name ?? 'N/A' }}</td>
                                            <td>{{ $purchase->purchaseOrder->supplier_sale_order_no ?? 'N/A' }}</td>
                                            <td>{{ $purchase->created_at ? \Carbon\Carbon::parse($purchase->created_at)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#purchaseItemsModal{{ $purchase->id }}">
                                                    <i class="ri-eye-line"></i> View Items
                                                </button>
                                                <div class="modal fade" id="purchaseItemsModal{{ $purchase->id }}" tabindex="-1" aria-labelledby="purchaseItemsModalLabel{{ $purchase->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="purchaseItemsModalLabel{{ $purchase->id }}">Purchase Items</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <ul class="list-group">
                                                                    @foreach($purchase->items as $item)
                                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                            <span>{{ $item->product->product_name }}</span>
                                                                            <span class="badge bg-danger rounded-pill">
                                                                                quantity : {{ $item->quantity }} x price : {{ $item->price }}
                                                                            </span>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                            <td>
                                                <a href="{{ route('purchase.edit', ['purchase' => $purchase->id]) }}" class="btn btn-link text-info">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <button class="btn btn-link text-danger fs-14 lh-1 p-0" data-bs-toggle="modal" data-bs-target="#deleteModal" wire:click="confirmDelete({{ $purchase->id }})"><i class="ri-delete-bin-5-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No purchase found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination Links -->
                        <div class="mt-3">
                            {{ $purchases->links('custom-pagination-links') }}
                        </div>

                        <!-- Bulk Delete Button -->
                        @if ($selectedPurchases)
                            <button class="btn btn-outline-danger mt-3" data-bs-toggle="modal" data-bs-target="#bulkDeleteConfirmationModal">
                                Delete
                            </button>
                        @endif
                    </div>
                    <!-- Single Delete Modal -->
                    <div wire:ignore.self data-bs-dismiss="modal" class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Delete Purchase</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this purchase?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger" wire:click="deleteConfirmed">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bulk Delete Confirmation Modal -->
                    <div wire:ignore.self data-bs-dismiss="modal" class="modal fade" id="bulkDeleteConfirmationModal" tabindex="-1" aria-labelledby="bulkDeleteConfirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bulkDeleteConfirmationModalLabel">Confirm Bulk Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete the selected purchases?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger" wire:click="bulkDelete">Delete All</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
