@extends('website.master')

@section('content')
    @livewire('crm.lead-list', ['userId' => $agentID ? $agentID : 0])

    {{-- <div class="container">
    <h1>Leads</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('agent.leads.create') }}" class="btn btn-primary mb-3">Create New Lead</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Source</th>
                <th>Segment</th>
                <th>Sub-Segment</th>
                <th>Expected Date</th>
                <th>Remarks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($leads as $lead)
                <tr>
                    <td>{{ $lead->id }}</td>
                    <td>{{ $lead->customer->name }}</td>
                    <td>{{ $lead->leadStatus->name }}</td>
                    <td>{{ $lead->leadSource->name }}</td>
                    <td>{{ $lead->segment->name }}</td>
                    <td>{{ $lead->subSegment ? $lead->subSegment->name : 'N/A' }}</td>
                    <td>{{\Carbon\Carbon::parse($lead->expected_date)->format('d-m-Y') }}</td>
                    <td>
                        @if ($lead->remarks->isNotEmpty())
                            @php
                                $latestRemark = $lead->remarks->sortByDesc('created_at')->first();
                            @endphp
                            <div>
                                <strong>{{ $latestRemark->user->name ?? 'Unknown User' }}</strong> 
                                ({{ $latestRemark->created_at->format('d-m-Y H:i') }}): 
                                <p>{{ $latestRemark->remark }}</p>
                            </div>
                        @else
                            <p>No remarks available.</p>
                        @endif

                    </td>
                    <td>
                        <a href="{{ route('agent.leads.edit', $lead->id) }}" class="btn btn-warning btn-sm">View</a>
                        <form action="{{ route('agent.leads.destroy', $lead->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this lead?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No leads found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div> --}}
@endsection