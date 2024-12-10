@extends('website.master')
@section('content')
<div class="container mt-4">
    <!-- Agent Information -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h4 class="m-0">Agent: {{ $agent->name }}'s DAR Reports</h4>
        </div>
        <div class="card-body">
            <p><strong>Agent's Name:</strong> {{ $agent->name }}</p>
            <p><strong>Role:</strong> {{ $agent->role }}</p>
        </div>
    </div>

    <!-- DAR Records Table -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="m-0">DAR Records</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Purpose of visit</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>vist Date</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dar as $item)
                        <tr>
                            <td>{{ $item->customer->name }}</td>
                            <td>{{ $item->purposeOfVisit->visitor_name }}</td>
                            <td>{{ $item->remarks }}</td>
                            <td>{{ $item->status == 1 ? 'Open' : 'Close' }}</td>
                            <td>{{ $item->date->format('Y-m-d ')  }}</td>
                            <td>{{ $item->created_at->format('Y-m-d ') }}</td>
                            <td>
                                <a href="{{ route('daily-report.edit', $item->dar_id) }}" class="btn btn-secondary btn-sm">Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection