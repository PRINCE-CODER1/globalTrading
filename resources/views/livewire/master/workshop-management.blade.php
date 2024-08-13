<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
            <h4>Workshops</h4>
            <a href="{{route('workshops.create')}}" class="btn btn-secondary btn-wave float-end">Create Workshop</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Per Page : {{ $perPage }}
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
                            <input wire:model.live.debounce.300ms="search" type="text" id="search" class="form-control" placeholder="search">
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="container">
                <div class="col-md-12 shadow">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap table-bordered">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" wire:model.live="selectAll">
                                            </th>
                                            <th>Workshop Name</th>
                                            <th>Branch Name</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($workshops as $workshop)
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model.live="selectedWorkshops" value="{{ $workshop->id }}">
                                            </td>
                                            <td>{{ $workshop->name }}</td>
                                            <td><p class="mb-0 badge bg-secondary">{{ $workshop->branch->name }}</p></td>
                                            <td>{{ \Carbon\Carbon::parse($workshop->created_at)->format('d M, Y') }}</td>
                                            <td>
                                                <div class="hstack gap-2 flex-wrap">
                                                    
                                                        <a href="{{route('workshops.edit',$workshop->id)}}" class="btn btn-link text-info fs-14 lh-1 p-0"><i class="ri-edit-line"></i></a>
                                                        {{-- @can('delete user') --}}
                                                        <button class="btn btn-link text-danger fs-14 lh-1 p-0" data-bs-toggle="modal" data-bs-target="#deleteSegmentModal" wire:click="confirmDelete({{ $workshop->id }})"><i class="ri-delete-bin-5-line"></i></button>
                                                        <!-- Delete Modal -->
                                                        <div wire:ignore.self class="modal fade" data-bs-dismiss="modal" id="deleteSegmentModal" tabindex="-1" aria-labelledby="deleteSegmentModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="deleteSegmentModalLabel">Delete</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form wire:submit.prevent="deleteConfirmed">
                                                                        <div class="modal-body">
                                                                            <h6>Are you sure you want to delete this Roles?</h6>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- @endcan --}}
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No Workshop found.</td>
                                            </tr>
                                        @endforelse
                                            
                                        
                                        
                                    </tbody>
                                </table>
                                <!-- Bulk Delete Button -->
                                <div class="mt-2">
                                    @if($selectedWorkshops)
                                        <button class="btn btn-outline-danger btn-wave" data-bs-toggle="modal" data-bs-target="#bulkDeleteConfirmationModal" >
                                            Delete
                                        </button>
                                        <!-- Bulk Delete Confirmation Modal -->
                                    <div wire:ignore.self class="modal fade" data-bs-dismiss="modal" id="bulkDeleteConfirmationModal" tabindex="-1" aria-labelledby="bulkDeleteConfirmationModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="bulkDeleteConfirmationModalLabel">Confirm Bulk Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>Are you sure you want to delete the selected leads?</h6>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-danger" wire:click="bulkDelete">
                                                        Confirm Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <!-- Pagination Links -->
                                <div class="mb-3">
                                    {{ $workshops->links('custom-pagination-links') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>