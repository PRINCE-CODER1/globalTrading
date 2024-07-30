<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Per Page : {{ $perPage }}
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage(2)">2</a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage(5)">5</a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage(10)">10</a></li>
                <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage(20)">20</a></li>
            </ul>
            <div class="ms-5">
                <select wire:model.live="userType" id="userType" class="form-select text-secondary">
                    <option value="">All</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="member">Member</option>
                </select>
            </div>
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
    <div class="table-responsive">
        <table class="table text-nowrap table-bordered">
            <thead>
                <tr>
                    <th scope="col" wire:click="setSortBy('name')">Name
                        @if ($sortBy === 'name')
                        @if ($sortDir === 'asc')
                            <i class="ri-arrow-up-s-line"></i>
                        @else
                            <i class="ri-arrow-down-s-line"></i>
                        @endif
                        @else
                        <i class="ri-expand-up-down-fill"></i>
                        @endif</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
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
                <tr wire:key="{{ $user->id }}">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="{{$user->role == 'user' ? 'text-primary' : 'text-warning'}}">
                        @if (!empty($user->getRoleNames()))
                            @foreach ($user->getRoleNames() as $rolename)
                                <label for="" class="badge bg-secondary">{{ $user->role }}</label>
                            @endforeach
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}</td>
                    <td>
                        <div class="hstack gap-2 flex-wrap">
                            <a href="{{route('admin.edit',$user->id)}}" class="text-info fs-14 lh-1"><i class="ri-edit-line"></i></a>
                            
                            <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" wire:click="confirmDelete({{ $user->id }})" class="btn btn-link text-danger fs-14 lh-1 p-0">
                                <i class="ri-delete-bin-5-line"></i>
                            </button>
                                <!-- Modal -->
                                <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1"data-bs-dismiss="modal" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form wire:submit.prevent="deleteConfirmed">
                                                <div class="modal-body">
                                                    <h4>Are You Sure To Delete User?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Delete</button>
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
                        <td colspan="4" class="text-center">No Users found.</td>
                    </tr>
                @endforelse
                    
                
                
            </tbody>
        </table>
        <!-- Pagination Links -->
        <div class="mb-3">
            {{ $users->links('custom-pagination-links') }}
        </div>
    </div>
    {{-- @push('scripts')
<script type="text/javascript">
    document.addEventListener('livewire:load', function () {
        Livewire.on('openDeleteModal', () => {
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        });
    });
</script>
@endpush --}}
</div>
