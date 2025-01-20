<div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card shadow-sm">
                    <div class="bg-secondary text-white p-3">
                        <h3 class="mb-0 text-white">Manager's Teams</h3>
                        <p class="mb-0 text-white">Details of teams managed by {{ $manager->name }}</p>
                    </div>
                    <div class="card-body table-responsive">
                        @if ($teams->isEmpty())
                            <p class="text-dark">No teams found for this manager.</p>
                        @else
                            <table class="table table-striped">
                                <thead class="table-secondary">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Team Name</th>
                                        <th scope="col">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teams as $index => $team)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $team->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($team->created_at)->format('d M Y, H:i') }}</td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <!-- Manager Details -->
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="bg-secondary  p-3">
                        <h3 class="mb-0 text-center text-white">Manager Details</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $manager->name }}</p>
                        <p><strong>Email:</strong> {{ $manager->email }}</p>
                        <p><strong>Teams Managed:</strong> {{ $teams->count()  }}</p>
                        <p><strong>Manager Leads:</strong> {{ $managerLeadsCount }}</p>
                    </div>
                </div>
            </div>   
        </div>
        <!-- Agents in Manager's Team -->
        <div class="card">
            <div class="bg-secondary p-3">
                <h3 class="mb-0 text-white">Manager: {{ $manager->name }} - Teams & Agents</h3>
            </div>
            <div class="card-body">
                @foreach($teams as $team)
                    <h4>Team: {{ $team->name }}</h4>
                    @if($team->agents->isEmpty())
                        <p>No agents assigned to this team.</p>
                    @else
                        <table class="table table-striped mb-2">
                            <thead>
                                <tr>
                                    <th>Agent Name</th>
                                    <th>Email</th>
                                    <th>Leads</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($team->agents as $agent)
                                    <tr>
                                        <td>
                                            <a href="{{ route('lead.agent', $agent->id) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $agent->name }}
                                            </a>
                                        </td>
                                        <td>{{ $agent->email }}</td>
                                        <td>
                                            {{ $agent->leads() 
                                                ->where('assigned_to', $agent->id)
                                                ->orWhereHas('assignedAgent', function($query) use ($agent) {
                                                    $query->where('id', $agent->id);
                                                })
                                                ->count() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @endforeach
            </div>
        </div>
        <!-- Leads Section -->
        {{-- <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Leads Created by Manager</h5>
                    </div>
                    <div class="card-body">
                        @if($leads->isEmpty())
                            <p>No leads created by this manager yet.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Lead ID</th>
                                        <th>Lead Reference Id</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leads as $lead)
                                        <tr>
                                            <td>{{ $lead->id }}</td>
                                            <td>{{ $lead->reference_id }}</td>
                                            <td>{{ $lead->leadStatus->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div> --}}
    </div> 
    <!-- Lead Filters Section -->
    <div class="container my-4">
        <div class="card shadow-sm rounded bg-secondary">
            <div class="card-body">
                <!-- Filters Row -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <!-- Status Filter -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter: {{ $statusFilter ?: 'All' }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" wire:click="$set('statusFilter', '')">All</a></li>
                            @foreach ($statuses as $status)
                                <li>
                                    <a class="dropdown-item" wire:click="$set('statusFilter', '{{ $status->name }}')">
                                        {{ $status->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Team Filter -->
                    {{-- <div class="btn-group">
                        <button type="button" class="btn btn-dark btn-wave dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Teams: {{ $teamFilter ?: 'All' }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" wire:click="$set('teamFilter', '')">All</a></li>
                            @foreach ($teams as $team)
                                <li>
                                    <a class="dropdown-item" wire:click="$set('teamFilter', '{{ htmlspecialchars($team->name) }}')">
                                        {{ $team->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        
                    </div> --}}

                    <!-- Per Page Filter -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark btn-wave dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Per Page: {{ $perPage }}
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ([2, 5, 10, 20] as $size)
                                <li>
                                    <a class="dropdown-item" href="#" wire:click.prevent="updatePerPage({{ $size }})">
                                        {{ $size }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Export Lead -->
                <div class="d-flex justify-content-between gap-3 mb-1 position-relative align-items-center">
                    <!-- Export as Excel -->
                    <button 
                        wire:click="exportLeads('xlsx')" 
                        wire:loading.attr="disabled" 
                        class="btn btn-dark btn-wave fw-bold d-flex align-items-center">
                        <i class="ri-file-excel-2-line me-1"></i> Export as Excel
                    </button>
                    
                    <!-- Export as CSV -->
                    <button 
                        wire:click="exportLeads('csv')" 
                        wire:loading.attr="disabled" 
                        class="btn btn-dark btn-wave fw-bold d-flex align-items-center">
                        <i class="ri-export-line me-1"></i> Export as CSV
                    </button>
                    
                    <!-- Loading Spinner -->
                    <div wire:loading class="spinner-border text-dark ms-2" role="status" style="width: 1.5rem; height: 1.5rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                </div>
                

                <!-- Search and Filters Row -->
                <div class="row mt-3">
                    <div class="col-md-9 d-flex gap-3">
                        <!-- Search Input -->
                        <div>
                            <input wire:model.live="search" type="text" id="search" class="form-control" placeholder="Search">
                        </div>

                        <!-- Date Filters -->
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <label for="" class="text-white">Start</label>
                            <input wire:model.live="startDate" type="date" class="form-control">
                        </div>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <label for="" class="text-white">End</label>
                            <input wire:model.live="endDate" type="date" class="form-control">
                        </div>
                    </div>

                    <!-- Reset Filters -->
                    <div class="col-md-3 d-flex justify-content-end">
                        <button wire:click="resetFilters" class="btn btn-danger">
                            <i class="bi bi-arrow-clockwise"></i> Reset Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>    

    <!-- Leads Table -->
    <div class="container mb-5">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap shadow-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="fw-bold">Action</th>
                                        <th class="fw-bold">Reference Id</th>
                                        <th class="fw-bold">Customer</th>
                                        <th class="fw-bold">Status</th>
                                        <th class="fw-bold">Series</th>
                                        <th class="fw-bold">Amount</th>
                                        <th class="fw-bold">Assigned Agent</th>
                                        <th class="fw-bold">Expected Month</th>
                                        <th class="fw-bold">Next Follow Up Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($leads as $lead)
                                        <tr>
                                            <td>
                                                <a class="btn btn-sm btn-info" href="{{ route('leads.edit', $lead->id) }}">
                                                    <i class="ri-eye-2-line"></i>
                                                </a>
                                                <button class="btn btn-link text-danger fs-14 lh-1 p-0"
                                                    data-bs-toggle="modal" data-bs-target="#deleteSegmentModal"
                                                    wire:click="confirmDelete({{ $lead->id }})">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                </button>
                                            </td>
                                            <td>{{ $lead->reference_id }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($lead->customer->name, 10) }}</td>
                                            <td>
                                                <span class="badge" style="background-color: {{ $lead->leadStatus->color }}; color: #fff;">
                                                    {{ $lead->leadStatus->name ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>{{ $lead->Series->name ?? 'N/A'  }}</td>
                                            <td>{{ $lead->amount  }}</td>
                                            <td>{{ $lead->assignedAgent->name }}</td>
                                            <td>{{ $lead->expected_date }}</td>
                                            <td>{{ $lead->remarks->last()?->date ?? 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <p class="mb-0">No records found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
    
                        <!-- Pagination Links -->
                        <div class="mt-3">
                            {{ $leads->links('custom-pagination-links') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Delete Modal -->
        <div wire:ignore.self data-bs-dismiss="modal" class="modal fade" id="deleteSegmentModal" tabindex="-1" aria-labelledby="deleteSegmentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteSegmentModalLabel">Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="deleteConfirmed">
                        <div class="modal-body">
                            <h6>Are you sure you want to delete this Lead?</h6>
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
        
   
</div>
