<div>
    <div class="container">
        <div class="row mt-5 mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h4>Purchase Orders</h4>
                <a href="{{ route('purchase_orders.create') }}" class="btn btn-secondary"><i class="me-2 ri-add-circle-line"></i>Create Purchase Order</a>
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
                    {{-- <div class="col-auto">
                        <label for="search" class="col-form-label">Search</label>
                    </div> --}}
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
                            <table class="table table-striped table-hover text-nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" wire:model.live="selectAll"></th>
                                        <th scope="col" wire:click="setSortBy('purchase_order_no')">Purchase Order No
                                           
                                            @if ($sortBy === 'purchase_order_no')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                            @else
                                                <i class="ri-expand-up-down-fill"></i>
                                            @endif
                                        </th>
                                        <th scope="col" wire:click="setSortBy('date')">Date
                                            @if ($sortBy === 'date')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                            @else
                                                <i class="ri-expand-up-down-fill"></i>
                                            @endif
                                        </th>
                                        <th scope="col" wire:click="setSortBy('supplier_id')">Supplier
                                            @if ($sortBy === 'supplier_id')
                                                <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                            
                                        </th>
                                        <th scope="col" wire:click="setSortBy('agent_id')">Agent/User
                                            @if ($sortBy === 'agent_id')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                            @else
                                                <i class="ri-expand-up-down-fill"></i>
                                            @endif
                                        </th>
                                        <th scope="col" wire:click="setSortBy('segment_id')">Segment
                                            @if ($sortBy === 'segment_id')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                            @else
                                                <i class="ri-expand-up-down-fill"></i>
                                            @endif
                                        </th>
                                        <th scope="col" wire:click="setSortBy('order_branch_id')">Order Branch
                                            @if ($sortBy === 'order_branch_id')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                            @else
                                                <i class="ri-expand-up-down-fill"></i>
                                            @endif
                                        </th>
                                        <th scope="col" wire:click="setSortBy('delivery_branch_id')">Delivery Branch
                                            @if ($sortBy === 'delivery_branch_id')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                            @else
                                                <i class="ri-expand-up-down-fill"></i>
                                            @endif
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
                                        <th>Product Details</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($purchaseOrders as $order)
                                        <tr wire:key="{{ $order->id }}">
                                            <td><input type="checkbox" wire:model.live="selectedOrders" value="{{ $order->id }}"></td>
                                            <td>{{ $order->purchase_order_no }}</td>
                                            <td>{{ $order->date }}</td>
                                            <td>{{ $order->supplier->name ?? 'N/A' }}</td>
                                            <td>{{ $order->agent->name ?? 'N/A' }}</td>
                                            <td>{{ $order->segment->name ?? 'N/A' }}</td>
                                            <td>{{ $order->orderBranch->name ?? 'N/A' }}</td>
                                            <td>{{ $order->deliveryBranch->godown_name ?? 'N/A' }}</td>
                                            <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                <!-- View Button -->
                                                <div class="d-flex justify-content-center">
                                                    <!-- View Button -->
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#viewPurchaseOrderModal{{ $order->id }}">
                                                        <i class="me-1 ri-eye-line"></i>View
                                                    </button>
                                                </div>                                               
                                                <!-- Modal for Viewing Purchase Order Details -->
                                                <div wire:igonre.self class="modal fade" id="viewPurchaseOrderModal{{ $order->id }}" tabindex="-1" aria-labelledby="viewPurchaseOrderModalLabel{{ $order->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="viewPurchaseOrderModalLabel{{ $order->id }}">Purchase Order Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table class="table table-bordered nowrap">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Product</th>
                                                                            <th>Quantity</th>
                                                                            <th>Price</th>
                                                                            <th>Discount</th>
                                                                            <th>Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($order->items as $item)
                                                                            <tr>
                                                                                <td>{{ $item->product->product_name }}</td>
                                                                                <td>{{ $item->quantity }}</td>
                                                                                <td>{{ $item->price }}</td>
                                                                                <td>{{ $item->discount }}</td>
                                                                                <td>{{ $item->quantity * $item->price }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>                                      
                                            
                                            
                                            <td>
                                                <a href="{{ route('purchase_orders.edit', $order->id) }}" class="btn btn-link text-info"><i class="ri-edit-line"></i></a>
                                                <button wire:click="confirmDelete({{ $order->id }})" class="btn btn-link text-danger fs-14 lh-1 p-0" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="ri-delete-bin-5-line"></i></button>
                                            </td>
                                        </tr>
                                    @empty 
                                        <tr>
                                            <td colspan="10" class="text-center">No purchase orders found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-3">
                            {{ $purchaseOrders->links('custom-pagination-links') }}
                        </div>

                        <!-- Bulk Delete Button -->
                        @if ($selectedOrders)
                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#bulkDeleteConfirmationModal">Delete</button>
                        @endif
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
                    <h5 class="modal-title" id="deleteModalLabel">Delete Purchase Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Purchase Order?
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
                    Are you sure you want to delete the selected Purchase Orders?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="bulkDelete">Delete All</button>
                </div>
            </div>
        </div>
    </div>
</div>
