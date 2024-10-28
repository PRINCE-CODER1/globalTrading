<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
                <h4>Create Internal Chalaan</h4>
                <a href="{{ route('internal.create') }}" class="btn btn-secondary btn-wave float-end"><i class="ri-add-circle-line"></i> Create Chalaan</a>
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
                                            <input type="checkbox" wire:model.live="selectAll">
                                        </th>
                                        <th>Reference ID</th>
                                        <th>Chalaan Type</th>
                                        <th>From Branch</th>
                                        <th>To Branch</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($internalChalaans as $chalaan)
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model.live="selectedInternalChalaan" value="{{ $chalaan->id }}">
                                            </td>
                                            <td>{{ $chalaan->reference_id }}</td>
                                            <td><span class="badge bg-secondary">{{ $chalaan->chalaanType->name }}</span></td>
                                            <td>{{ $chalaan->fromBranch->name }}</td>
                                            <td>{{ $chalaan->toBranch->name }}</td>
                                            <td>
                                                <a href="{{ route('internal.edit', $chalaan->id) }}" class="btn btn-sm text-info"><i class="ri-edit-line"></i> Edit</a>
                                                <button wire:click="confirmDelete({{ $chalaan->id }})"class="btn btn-sm btn-danger " 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteSegmentModal" >
                                                    <i class="ri-delete-bin-line"></i> Delete
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
                                        @empty
                                        <tr>
                                            <td class="text-center" colspan="8">
                                                No records found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $internalChalaans->links('custom-pagination-links') }}
                        </div>
                        <div class="mt-2">
                            @if($selectedInternalChalaan)
                                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#bulkDeleteConfirmationModal">Delete Selected</button>
                                
                                <!-- Bulk Delete Confirmation Modal -->
                                <div wire:ignore.self class="modal fade" id="bulkDeleteConfirmationModal" tabindex="-1" aria-labelledby="bulkDeleteConfirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="bulkDeleteConfirmationModalLabel">Confirm Bulk Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete the selected Internal Chalaans?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-danger" wire:click="bulkDelete" data-bs-dismiss="modal">Confirm Delete</button>
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
