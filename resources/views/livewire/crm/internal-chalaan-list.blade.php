<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
                <h4>Create Iternal Chalaan</h4>
                <a href="{{ route('internal.create') }}" class="btn btn-secondary btn-wave float-end"><i class="ri-add-circle-line"></i> Create Chalaan</a>
            </div>
        </div>
    
        <div class="row mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Per Page: 
                    </button>
                    <ul class="dropdown-menu">
                        @foreach ([2, 5, 10, 20] as $size)
                            <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage({{ $size }})">{{ $size }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="d-flex align-items-center">
                    <div class="col-auto">
                        <input wire:model.live="search" type="text" id="search" class="form-control" placeholder="Search">
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <input type="checkbox" wire:model.live="selectAll">
                                        </th>
                                        <th>Reference ID</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Chalaan Type</th>
                                        <th>Branch</th>
                                        <th>Godown</th>
                                        <th>Customer</th>
                                        <th>Created By</th>
                                        <th>Created On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @forelse ($externalChalaans as $chalaan)
                                        @foreach ($chalaan->chalaanProducts as $productData)
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model.live="selectedExternalChalaan" value="{{ $chalaan->id }}">
                                            </td>
                                            <td>{{ $chalaan->reference_id }}</td>
                                            <td>{{ $productData->product->product_name ?? 'N/A' }}</td>
                                            <td>{{ $productData->quantity }}</td>
                                            <td><span class="badge bg-secondary">{{ $chalaan->chalaanType->name  ?? 'N/A'}}</span></td>
                                            <td>{{ $productData->branch->name ?? 'N/A' }}</td>
                                            <td>{{ $productData->godown->godown_name ?? 'N/A' }}</td>
                                            <td>{{ $chalaan->customer->name ?? 'N/A' }}</td>
                                            <td>{{ $chalaan->createdby->name ?? 'N/A' }}</td>
                                            <td>{{ $chalaan->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <a href="{{ route('external.edit', $chalaan->id) }}" class="btn btn-link text-info"><i class="ri-edit-line"></i></a>
                                                <button class="btn btn-link text-danger fs-14 lh-1 p-0" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteSegmentModal" 
                                                    wire:click="confirmDelete({{ $chalaan->id }})">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                </button>
                                                <!-- Delete Confirmation Modal -->
                                                <div wire:ignore.self class="modal fade" data-bs-dismiss="modal" id="deleteSegmentModal" tabindex="-1" aria-labelledby="deleteSegmentModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteSegmentModalLabel">Confirm Delete</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this Chalaan?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button" class="btn btn-danger" wire:click="deleteConfirmed">Confirm Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No External Chalaan found.</td>
                                        </tr>
                                    @endforelse --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{-- {{ $externalChalaans->links('custom-pagination-links') }} --}}
                        </div>
                        <div class="mt-2">
                            {{-- @if($selectedExternalChalaan)
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#bulkDeleteConfirmationModal">Delete</button>
                                <div wire:ignore.self class="modal fade" data-bs-dismiss="modal" id="bulkDeleteConfirmationModal" tabindex="-1" aria-labelledby="bulkDeleteConfirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="bulkDeleteConfirmationModalLabel">Confirm Bulk Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete the selected external Chalaan?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-danger" wire:click="bulkDelete">Confirm Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif --}}
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
