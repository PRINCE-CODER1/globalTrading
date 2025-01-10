<div>
    <div class="container mt-5">
         <div class="row">
             <div class="col-12 col-md-12">
                 <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            Personal Info
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($agent)
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="me-2 fw-medium">
                                        Name :
                                    </div>
                                    <span class="fs-12 text-muted">{{ $agent->name }}</span>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="me-2 fw-medium">
                                        Email :
                                    </div>
                                    <span class="fs-12 text-muted">{{ $agent->email }}</span>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="me-2 fw-medium">
                                        Total Leads :
                                    </div>
                                    <span class="fs-12 text-muted">
                                        {{ $agent->leads()
                                        ->where('assigned_to', $agent->id)
                                        ->orWhereHas('assignedAgent', function($query) use ($agent) {
                                            $query->where('id', $agent->id);
                                        })
                                        ->count() }}</span>
                                </div>
                            </li>
                        </ul>
                        @endif
                    </div>
                </div>
             </div>
         </div>
     </div>
 </div>
 