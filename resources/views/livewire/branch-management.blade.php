<div>
    <div class="container">
        <div class="row mt-5 mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h4>Branches</h4>
                <a href="{{ route('branches.create') }}" class="btn btn-secondary">Create Branch</a>
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

                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="search" class="col-form-label">Search</label>
                    </div>
                    <div class="col-auto">
                        <input wire:model.debounce.300ms="search" type="text" id="search" class="form-control" placeholder="Search">
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" wire:model="selectAll">
                                        </th>
                                        <th>User Name</th>
                                        <th>Branch Name</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($branches as $branch)
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model="selectedBranches" value="{{ $branch->id }}">
                                            </td>
                                            <td>{{ $branch->user->name }}</td>
                                            <td><p class="mb-0 badge bg-secondary">{{ $branch->name }}</p></td>
                                            <td>{{ $branch->mobile }}</td>
                                            <td>{{ $branch->address }}</td>
                                            <td>{{ $branch->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('branches.edit', $branch->id) }}" class="btn btn-link text-info"><i class="ri-edit-line"></i></a>
                                                    @can('delete branch')
                                                        <button class="btn btn-link text-danger" wire:click="confirmDelete({{ $branch->id }})"><i class="ri-delete-bin-5-line"></i></button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No branches found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Bulk Delete Button -->
                <div class="mt-2">
                    @if($selectedBranches)
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#bulkDeleteConfirmationModal">Delete Selected</button>
                    @endif
                </div>

                <!-- Pagination Links -->
                <div class="mt-3">
                    {{ $branches->links('custom-pagination-links') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Branch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this branch?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteConfirmed">Delete</button>
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
                    Are you sure you want to delete the selected branches?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="bulkDelete">Confirm Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
