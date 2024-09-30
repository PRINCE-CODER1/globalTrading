@extends('website.master')

@section('content')
<div class="container">
    <div class="row mt-5 mb-3">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Agents</h4>
            <a href="{{ route('teams.index') }}" class="btn btn-secondary"><i class="ri-arrow-left-s-line"></i> Back</a>
        </div>
    </div>
    <hr>
</div>
<div class="container">
    <h2 class="fw-bold">Leads for : <span class="text-secondary">{{ $user->name }}</span></h2>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Lead Name</th>
                                    <th>Status</th>
                                    <th>Source</th>
                                    <th>Created Date</th>
                                    <th>Last Updated</th>
                                    <th>Contact Information</th>
                
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leads as $lead)
                                
                                    <tr>
                                        <td>{{ $lead->id }}</td>
                                        <td>{{ $lead->customer->name }}</td>
                                        <td>
                                            <span class="badge" style="background-color: {{ $lead->leadStatus->color }}; color: #fff;">
                                                {{ $lead->leadStatus->name }}
                                            </span>
                                        </td>
                                        <td>{{ $lead->leadSource->name }}</td>
                                        <td>{{ $lead->created_at->format('d-m-Y ') }}</td>
                                        <td>{{ $lead->updated_at->format('d-m-Y ') }}</td>
                                        <td>
                                            <p><span class="fw-semibold">Phone:</span>  {{ $lead->customer->mobile_no }}</p>
                                            <p><span class="fw-semibold">Address:</span> {{ $lead->customer->address }}</p>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No Agent Record found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
