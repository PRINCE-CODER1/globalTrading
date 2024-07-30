<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
                <h4>Units of Measurement</h4>
                <a href="{{ route('units.create') }}" class="btn btn-secondary btn-wave float-end">Create New Unit</a>
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
                                            <th scope="col">
                                                <input type="checkbox" wire:model.live="selectAll">
                                            </th>
                                            <th scope="col" wire:click="setSortBy('symbol')">Symbol
                                                @if ($sortBy === 'symbol')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                                @else
                                                    <i class="ri-expand-up-down-fill"></i>
                                                @endif
                                            </th>
                                            <th scope="col" wire:click="setSortBy('formula_name')">Formula Name
                                                @if ($sortBy === 'formula_name')
                                                @if ($sortDir === 'asc')
                                                    <i class="ri-arrow-up-s-line"></i>
                                                @else
                                                    <i class="ri-arrow-down-s-line"></i>
                                                @endif
                                                @else
                                                    <i class="ri-expand-up-down-fill"></i>
                                                @endif
                                            </th>
                                            <th scope="col">Has Decimals</th>
                                            <th scope="col" scope="col" wire:click="setSortBy('decimal_places')">Decimal Places
                                                @if ($sortBy === 'symbol')
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
                                        @forelse($units as $unit)
                                        <tr wire:key="{{ $unit->id }}">
                                            <td>
                                                <input type="checkbox" wire:model.live="selectedUnitIds" value="{{ $unit->id }}">
                                            </td>
                                            <td>{{ $unit->symbol }}</td>
                                            <td>{{ $unit->formula_name }}</td>
                                            <td>{{ $unit->has_decimals ? 'Yes' : 'No' }}</td>
                                            <td>
                                                @if($unit->has_decimals)
                                                    {{ number_format(0, $unit->decimal_places) }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('units.edit',$unit->id)}}" class="btn btn-link text-info fs-14 lh-1 p-0"><i class="ri-edit-line"></i></a>
                                                <button class="btn btn-link text-danger fs-14 lh-1 p-0" data-bs-toggle="modal" data-bs-target="#deleteSegmentModal" wire:click="confirmDelete({{ $unit->id }})"><i class="ri-delete-bin-5-line"></i></button>
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
                                                                            <button type="submit" class="btn btn-primary">Delete</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No permissions found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-2">
                                    @if($selectedUnitIds)
                                    <button class="btn btn-outline-danger btn-wave" data-bs-toggle="modal" data-bs-target="#bulkDeleteConfirmationModal">Delete</button>
                                        <!-- Bulk Delete Confirmation Modal -->
                                        <div wire:ignore.self class="modal fade" id="bulkDeleteConfirmationModal" tabindex="-1" aria-labelledby="bulkDeleteConfirmationModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="bulkDeleteConfirmationModalLabel">Confirm Bulk Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6>Are you sure you want to delete the selected units?</h6>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-danger" wire:click="bulkDelete">Confirm Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                {{ $units->links('custom-pagination-links') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
