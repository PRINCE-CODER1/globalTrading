<div>
    <div class="container p-4">
        <h3 class="mb-4 my-2">Activity Reports</h3>
    
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title">Agent Details</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 ">
                        <strong class="text-muted">Agent Name</strong>
                        <h5>{{ $user->name }}</h5>
                    </div>
                    <div class="col-md-6 ">
                        <strong class="text-muted">Email</strong>
                        <h5>{{ $user->email }}</h5>
                    </div>
                    <div class="col-md-6 ">
                        <strong class="text-muted">Role</strong>
                        <h5>{{ $user->roles->first()->name }}</h5>
                    </div>
                    <div class="col-md-6 ">
                        <strong class="text-muted">Joined On</strong>
                        <h5>{{ $user->created_at->format('M d, Y') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Activity Reports</h5>
                <div>
                   <input 
                       type="text" 
                       class="form-control mb-0" 
                       placeholder="Search Activity Reports..." 
                       wire:model.live="search">
               </div> 
            </div>
             
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Contact Person</th>
                            <th>Purpose of Visit</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            <th>Rating</th>
                            <th>Visit Date</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($darReports as $darReport)
                            <tr>
                                <td>{{ $darReport->customer->name }}</td>
                                <td>{{ $darReport->customerUser->name ?? "N/A" }}</td>
                                <td>{{ $darReport->purposeOfVisit->visitor_name }}</td>
                                <td>{{ $darReport->remarks }}</td>
                                <td>
                                    <span class="badge 
                                        @if($darReport->status == 1) 
                                            bg-secondary 
                                        @else 
                                            bg-danger 
                                        @endif">
                                        {{ $darReport->status == 1 ? 'Completed' : 'Pending' }}
                                    </span>
                                </td>
                                <td> @if($darReport->rating != null) ⭐ @endif <b>{{ $darReport->rating }}</b></td>
                                <td>{{ $darReport->date->format('D, M d, Y') }}</td>
                                <td>{{ $darReport->created_at->format('D, M d, Y') }}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No Records Founds</td>
                                </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mb-3">
                    {{ $darReports->links('custom-pagination-links') }}
                </div>
            </div>
        </div>
    </div>
</div>
