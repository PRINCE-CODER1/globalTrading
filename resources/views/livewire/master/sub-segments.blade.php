<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between">
                <h4 class="mb-0">
                    @if ($isEditing)
                        Edit Sub-Segment
                    @elseif (!$viewSubSegments)
                        Create Sub-Segment
                    @else
                        Sub-Segment List
                    @endif
                </h4>
                @if ($viewSubSegments)
                    <button wire:click="createSubSegment" class="btn btn-outline-secondary btn-wave">
                        Create Sub-Segment
                    </button>
                @elseif($isEditing)
                    <button wire:click="toggleView" class="btn btn-outline-secondary btn-wave">
                        Cancel Editing
                    </button>
                @else
                    <button wire:click="toggleView" class="btn btn-outline-secondary btn-wave">
                        Show Sub-Segments
                    </button>
                @endif
            </div>           
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('sub-segments.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Segments</a></li>
                        @if ($isEditing)
                            <li class="breadcrumb-item active" aria-current="page">Edit Sub-Segment</li>
                        @elseif (!$viewSubSegments)
                            <li class="breadcrumb-item active" aria-current="page">Create Sub-Segment</li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">Sub-Segments List</li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="container">
                <div class="col-md-12 mt-3 mb-5 shadow">
                    <div class="card">
                        <div class="card-body">
                            <!-- Sub-Segment Form -->
                            @if (!$viewSubSegments)
                                <form wire:submit.prevent="store">
                                    <div class="mb-3">
                                        <label for="name" class="form-label fs-14 text-dark">Enter name</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-text"><i class="ri-user-line"></i></div>
                                            <input wire:model="name" type="text" class="form-control" id="name" placeholder="Enter name">
                                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <p>Status</p>
                                        <label for="active" class="switch fs-14 text-dark">
                                            <input wire:model.defer="active" type="checkbox" id="active" {{ $active ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                        @error('active') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="parentId" class="form-label fs-14 text-dark">Parent Segment</label>
                                        <select wire:model="parentId" class="form-control" id="parentId">
                                            <option value="">Select Parent Segment</option>
                                            @foreach($parentSegments as $segment)
                                                <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('parentId') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <button class="btn btn-secondary">Submit</button>
                                    </div>
                                </form>
                            @endif

                            <!-- Sub-Segments Table -->
                            @if ($viewSubSegments)
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
                                                <th scope="col">Status</th>
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
                                                <th scope="col" wire:click="setSortBy('parent_id')">Parent Segment
                                                    @if ($sortBy === 'parent_id ')
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
                                            @forelse($segments as $segment)
                                                <tr wire:key="{{ $segment->id }}">
                                                    <td>
                                                        <input type="checkbox" wire:model.live.debounce.300ms="selectedSegments" value="{{ $segment->id }}">
                                                    </td>
                                                    <td>{{ $segment->name }}</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" 
                                                                   wire:click="toggleStatus({{ $segment->id }})" 
                                                                   {{ $segment->active ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($segment->created_at)->format('d M, Y') }}</td>
                                                    <td>{{ $segment->parent ? $segment->parent->name : 'None' }}</td>
                                                    <td>
                                                        <a wire:click="edit({{ $segment->id }})" class="text-info fs-14 lh-1"><i class="ri-edit-line"></i></a>
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#deletesegModal" wire:click="confirmDelete({{ $segment->id }})" class="btn btn-link text-danger fs-14 lh-1 p-0">
                                                            <i class="ri-delete-bin-5-line"></i>
                                                        </button>

                                                        <!-- Delete Modal -->
                                                        <div wire:ignore.self class="modal fade" data-bs-dismiss="modal" id="deletesegModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form wire:submit.prevent="deleteConfirmed">
                                                                        <div class="modal-body">
                                                                            <h6>Are you sure you want to delete this sub-segment?</h6>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No sub-segments found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Bulk Delete Button -->
                                <div class="mt-2">
                                    @if($selectedSegments)
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
                                <div class="mb-3">
                                    {{ $segments->links('custom-pagination-links') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
