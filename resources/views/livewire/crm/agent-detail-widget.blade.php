<div>
    <div class="container mt-5">
         <div class="row justify-content-center">
             <div class="col-12 col-md-12">
                 <div class="card shadow-lg">
                     <div class="card-header bg-primary text-white">
                         <h3 class="mb-0">Agent Details</h3>
                     </div>
                     <div class="card-body">
                         @if ($agent)
                             <!-- Agent Information -->
                             <div class="row mb-3">
                                 <div class="col-md-4">
                                     <h5>Name:</h5>
                                 </div>
                                 <div class="col-md-8">
                                     <p class="lead">{{ $agent->name }}</p>
                                 </div>
                             </div>
 
                             <div class="row mb-3">
                                 <div class="col-md-4">
                                     <h5>Email:</h5>
                                 </div>
                                 <div class="col-md-8">
                                     <p class="lead">{{ $agent->email }}</p>
                                 </div>
                             </div>
 
                             <div class="row mb-3">
                                 <div class="col-md-4">
                                     <h5>Assigned Team(s):</h5>
                                 </div>
                                 <div class="col-md-8">
                                     <div class="d-flex flex-wrap">
                                         @forelse ($agent->teams as $team)
                                             <span class="badge bg-dark me-2 mb-2">{{ $team->name }}</span>
                                             @empty
                                             <span> no team assign</span>
                                         @endforelse
                                     </div>
                                 </div>
                             </div>
 
                             <div class="row mb-3">
                                 <div class="col-md-4">
                                     <h5>Total Leads:</h5>
                                 </div>
                                 <div class="col-md-8">
                                     <p class="lead">{{ $agent->leads->count() }}</p>
                                 </div>
                             </div>
                         @else
                             <p class="text-danger">No agent found with this ID.</p>
                         @endif
                     </div>
                     
                 </div>
             </div>
         </div>
     </div>
 </div>
 