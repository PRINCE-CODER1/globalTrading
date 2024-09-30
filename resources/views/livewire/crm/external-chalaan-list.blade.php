<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
                <h4>Create External Chalaan</h4>
                <a href="{{ route('external.create') }}" class="btn btn-secondary btn-wave float-end"><i class="ri-add-circle-line"></i> Create Chalaan</a>
            </div>
        </div>
    
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
                                            <input type="checkbox" wire:model="selectAll">
                                        </th>
                                        {{-- <th>Reference ID</th> --}}
                                        {{-- <th>Product</th> --}}
                                        <th wire:click="setSortBy('reference_id')" style="cursor: pointer;">
                                            Reference ID @if($sortBy === 'reference_id') <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span> @endif
                                        </th>
                                        <th wire:click="setSortBy('product.name')" style="cursor: pointer;">
                                            Product @if($sortBy === 'product.name') <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span> @endif
                                        </th>
                                        <th wire:click="setSortBy('branch.name')" style="cursor: pointer;">
                                            Branch @if($sortBy === 'branch.name') <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span> @endif
                                        </th>
                                        <th wire:click="setSortBy('godown.name')" style="cursor: pointer;">
                                            Godown @if($sortBy === 'godown.name') <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span> @endif
                                        </th>
                                        <th wire:click="setSortBy('customer.name')" style="cursor: pointer;">
                                            Customer @if($sortBy === 'customer.name') <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span> @endif
                                        </th>
                                        <th wire:click="setSortBy('created_at')" style="cursor: pointer;">
                                            Created At @if($sortBy === 'created_at') <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span> @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($externalChalaans as $chalaan)
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model.live="selectedExternalChalaan" value="{{ $chalaan->id }}">
                                            </td>
                                            <td>{{ $chalaan->reference_id }}</td>
                                            {{-- <td>{{ $chalaan->product->name ?? 'N/A' }}</td>
                                            <td>{{ $chalaan->branch->name ?? 'N/A' }}</td>
                                            <td>{{ $chalaan->godown->name ?? 'N/A' }}</td>
                                            <td>{{ $chalaan->customer- ?? 'N/A' }}</td> --}}
                                            <td>{{ $chalaan->created_at->format('Y-m-d H:i:s')  }}</td>
                                            <td>
                                                <a href="{{ route('external.edit', $chalaan->id) }}" class="btn btn-link text-info"><i class="ri-edit-line"></i></a>
                                                <button class="btn btn-link text-danger fs-14 lh-1 p-0" data-bs-toggle="modal" data-bs-target="#deleteSegmentModal" wire:click="confirmDelete({{ $chalaan->id }})">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No External Chalaan found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $externalChalaans->links('custom-pagination-links') }}
                        </div>
                        <div class="mt-2">
                            @if($selectedExternalChalaan)
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
                            @endif
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
