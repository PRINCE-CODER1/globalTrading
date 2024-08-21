<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between">
                <h4 class="mb-0">
                    @if ($isEditing)
                        Edit Segment
                    @elseif (!$viewSegments)
                        Create Segment
                    @else
                        Segments List
                    @endif
                </h4>
                @if ($viewSegments)
                    <button wire:click="createSegment" class="btn btn-outline-secondary">
                        <i class="bi bi-plus-circle"></i> Create Segment
                    </button>
                @elseif($isEditing)
                    <button wire:click="toggleView" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Cancel Editing
                    </button>
                @else
                    <button wire:click="toggleView" class="btn btn-outline-secondary">
                        <i class="bi bi-list"></i> Segment Lists
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
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="bi bi-house-door"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('segments.index')}}"><i class="bi bi-grid"></i> Segments</a></li>
                        @if ($isEditing)
                            <li class="breadcrumb-item active" aria-current="page">Edit Segment</li>
                        @elseif (!$viewSegments)
                            <li class="breadcrumb-item active" aria-current="page">Create Segment</li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">Segments List</li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="container">
                <div class="col-md-12 mb-5 mt-3 shadow">
                    <div class="card">
                        <div class="card-body">
                            <!-- Segment Form (Create/Edit) -->
                            @if (!$viewSegments)
                                <form wire:submit.prevent="store">
                                    <div class="mb-3">
                                        <label for="name" class="form-label fs-14 text-dark">Enter Name</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-text"><i class="bi bi-person"></i></div>
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
                                        <button class="btn btn-secondary"><i class="bi bi-check2"></i> Submit</button>
                                    </div>
                                </form>
                            @endif
    
                            <!-- Segments Table -->
                            @if ($viewSegments)
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
                                                            <i class="bi bi-arrow-up"></i>
                                                        @else
                                                            <i class="bi bi-arrow-down"></i>
                                                        @endif
                                                    @else
                                                        <i class="bi bi-sort-down-alt"></i>
                                                    @endif
                                                </th>
                                                <th scope="col">Status</th>
                                                <th scope="col" wire:click="setSortBy('created_at')">Created On
                                                    @if ($sortBy === 'created_at')
                                                        @if ($sortDir === 'asc')
                                                            <i class="bi bi-arrow-up"></i>
                                                        @else
                                                            <i class="bi bi-arrow-down"></i>
                                                        @endif
                                                    @else
                                                        <i class="bi bi-sort-down-alt"></i>
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
                                                    <td>
                                                        <a wire:click="edit({{ $segment->id }})" class="text-info fs-14 lh-1" style="cursor: pointer;">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteSegmentModal" wire:click="confirmDelete({{ $segment->id }})" class="btn btn-link text-danger fs-14 lh-1 p-0">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                        
                                                        <!-- Delete Modal -->
                                                        <div wire:ignore.self class="modal fade" id="deleteSegmentModal" tabindex="-1" aria-labelledby="deleteSegmentModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="deleteSegmentModalLabel">Delete</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form wire:submit.prevent="deleteConfirmed">
                                                                        <div class="modal-body">
                                                                            <h6>Are you sure you want to delete this segment?</h6>
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
                                                    <td colspan="5" class="text-center">No segments found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Bulk Delete Button -->
                                <div class="mt-2">
                                    @if($selectedSegments)
                                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#bulkDeleteConfirmationModal">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                        <!-- Bulk Delete Confirmation Modal -->
                                        <div wire:ignore.self class="modal fade" id="bulkDeleteConfirmationModal" tabindex="-1" aria-labelledby="bulkDeleteConfirmationModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="bulkDeleteConfirmationModalLabel">Confirm Bulk Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6>Are you sure you want to delete the selected segments?</h6>
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
