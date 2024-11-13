<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
            <h4 class="mb-0">User's List</h4>
            <a href="{{route('users.create')}}" class="btn btn-secondary btn-wave float-end">Create User</a>
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
                    <div class="d-flex align-items-center">
                        {{-- <div class="col-auto">
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
            <div class="container">
                <div class="col-md-12 shadow">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap table-bordered">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" wire:model.live.debounce.300ms="selectAll">
                                            </th>
                                            <th scope="col" wire:click="setSortBy('name')">
                                                Name
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
                                            <th scope="col" wire:click="setSortBy('email')">
                                                Email
                                                @if ($sortBy === 'email')
                                                    @if ($sortDir === 'asc')
                                                        <i class="ri-arrow-up-s-line"></i>
                                                    @else
                                                        <i class="ri-arrow-down-s-line"></i>
                                                    @endif
                                                @else
                                                    <i class="ri-expand-up-down-fill"></i>
                                                @endif
                                            </th>
                                            <th>Role</th>
                                            <th scope="col" wire:click="setSortBy('created_at')">Created On
                                                @if ($sortBy === 'created_at')
                                                    @if ($sortDir === 'asc')
                                                        <i class="ri-arrow-up-s-line"></i>
                                                    @else
                                                        <i class="ri-arrow-down-s-line"></i>
                                                    @endif
                                                @else
                                                <i class="ri-expand-up-down-fill"></i>
                                                @endif
                                            </th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $user)
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model.live.debounce.300ms="selectedUserIds" value="{{ $user->id }}">
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->roles->isNotEmpty())
                                                <div class="d-flex flex-wrap gap-2" style="max-width:300px">
                                                    @foreach ($user->roles as $role)
                                                        <span class="badge bg-secondary">{{ $role->name }}</span>
                                                    @endforeach
                                                </div>
                                                @else
                                                <p class="mb-0 badge bg-danger">No roles assigned</p>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}</td>
                                            <td>
                                                <div class="hstack gap-2 flex-wrap">
                                                    
                                                        <a href="{{route('users.edit',$user->id)}}" class="btn btn-link text-info fs-14 lh-1 p-0"><i class="ri-edit-line"></i></a>
                                                        @can('delete user')
                                                        <button class="btn btn-link text-danger fs-14 lh-1 p-0" data-bs-toggle="modal" data-bs-target="#deleteSegmentModal" wire:click="confirmDelete({{ $user->id }})"><i class="ri-delete-bin-5-line"></i></button>
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
                                                        @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No Users found.</td>
                                            </tr>
                                        @endforelse
                                            
                                        
                                        
                                    </tbody>
                                </table>
                                <!-- Bulk Delete Button -->
                                <div class="mt-2">
                                    @if($selectedUserIds)
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
                                    {{ $users->links('custom-pagination-links') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
