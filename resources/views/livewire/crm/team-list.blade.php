<div>
    <div class="container">
        <div class="row mt-5 mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Team</h4>
                <a href="{{ route('teams.create') }}" class="btn btn-secondary"><i class="ri-add-circle-line"></i> Create Team</a>
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
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <input type="checkbox" wire:model.live="selectAll">
                                        </th>
                                        <th>Team Name</th>
                                        <th>Assigned Agents</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($teams as $team)
                                        <tr wir:key="{{$team->id}}">
                                            <td>
                                                <input type="checkbox" wire:model.live="selectedTeams" value="{{ $team->id }}">
                                            </td>
                                            <td>{{ $team->name }}</td>
                                            <td>
                                                @if($team->agents->isEmpty())
                                                    <span class="text-muted">No agents assigned</span>
                                                @else
                                                    <div class="d-flex flex-wrap">
                                                        @foreach($team->agents as $agent)
                                                            <div class="badge bg-info text-white me-1 mb-1">
                                                                <a href="{{ route('agents.leads', $agent->id) }}" class="text-white text-decoration-none" data-bs-toggle="tooltip" title="View leads for {{ $agent->name }}">
                                                                    <i class="fas fa-user"></i> {{ $agent->name }}
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-link text-info"><i class="ri-edit-line"></i></a>    
                                                
                                                <button class="btn btn-link text-danger fs-14 lh-1 p-0 me-3" data-bs-toggle="modal" data-bs-target="#deleteSegmentModal" wire:click="confirmDelete({{ $team->id }})">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                </button>
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
                                                                    <h6>Are you sure you want to delete this Team?</h6>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                <a href="{{ route('manager.teams.show-assign-form', $team->id) }}" class="btn btn-dark"><i class="ri-map-pin-add-line"></i> Assign Agents</a>
                                            </td>
                                        </tr>
                                        @empty
                                                <tr>
                                                    <td colspan="10" class="text-center">No Teams found.</td>
                                                </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $teams->links('custom-pagination-links') }}
                            </div>
                        </div>
                        <!-- Bulk Delete Button -->
                        <div class="mt-2">
                            @if($selectedTeams)
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
                                                Are you sure you want to delete the selected Teams?
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
