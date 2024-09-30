<div>
    <div class="container">
        <div class="row mt-5 mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Challan Types</h4>
                <a href="{{ route('challan-types.create') }}" class="btn btn-secondary"><i class="ri-add-circle-line"></i> Create Challan Type</a>
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
                    {{-- <div class="col-auto d-none d-md-block">
                        <label for="search" class="form-label">Search</label>
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
                                        <th wire:click="setSortBy('name')">Name
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
                                        <th wire:click="setSortBy('description')">Description
                                            @if ($sortBy === 'description')
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
                                    @forelse ($challanTypes  as $challanType)
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model.live="selectedChallanTypes" value="{{ $challanType->id }}">
                                            </td>
                                            <td>{{ $challanType->name }}</td>
                                            <td>{{ $challanType->description }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('challan-types.edit', $challanType->id) }}" class="btn btn-link text-info"><i class="ri-edit-line"></i></a>
                                                    <button class="btn btn-link text-danger fs-14 lh-1 p-0" data-bs-toggle="modal" data-bs-target="#deleteSaleTypeModal" wire:click="confirmDelete({{ $challanType->id }})"><i class="ri-delete-bin-5-line"></i></button>
                                                    <!-- Delete Modal -->
                                                    <div wire:ignore.self class="modal fade" data-bs-dismiss="modal" id="deleteSaleTypeModal" tabindex="-1" aria-labelledby="deleteSaleTypeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteSaleTypeModalLabel">Delete Sale Type</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form wire:submit.prevent="deleteConfirmed">
                                                                    <div class="modal-body">
                                                                        <h6>Are you sure you want to delete this sale type?</h6>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No challan types found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Bulk Delete Button -->
                        <div class="mt-2">
                            @if($selectedChallanTypes)
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#bulkDeleteConfirmationModal">Delete</button>
                                <!-- Bulk Delete Confirmation Modal -->
                                <div wire:ignore.self class="modal fade" data-bs-dismiss="modal" id="bulkDeleteConfirmationModal" tabindex="-1" aria-labelledby="bulkDeleteConfirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="bulkDeleteConfirmationModalLabel">Confirm Bulk Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete the selected sale types?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-danger" wire:click="bulkDelete">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-3">
                            <div>
                                {{ $challanTypes->links('custom-pagination-links') }}
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
