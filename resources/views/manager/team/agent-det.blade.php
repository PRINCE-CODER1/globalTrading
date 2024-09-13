@extends('website.master')

@section('content')
<div class="container">
    <h2>Leads for {{ $user->name }}</h2>

    @if($leads->isEmpty())
        <p>No leads assigned to this agent.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Lead Name</th>
                    <th>Status</th>
                    <th>Source</th>
                    <th>Created Date</th>
                    <th>Last Updated</th>
                    <th>Contact Information</th>
                    {{-- <th>Notes</th>
                    <th>Activities</th>
                    <th>Follow-up Dates</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($leads as $lead)
                @php
                    $badgeColors = [
                        'New' => 'bg-primary',
                        'Qualified' => 'bg-info',
                        'Contacted' => 'bg-warning',
                        'Proposal Sent' => 'bg-secondary',
                        'Won' => 'bg-success',
                        'Sent' => 'bg-dark',
                        'Lost' => 'bg-danger',
                    ];
                    $statusColor = $badgeColors[$lead->leadStatus->name] ?? 'bg-light';
                @endphp
                    <tr>
                        <td>{{ $lead->id }}</td>
                        <td>{{ $lead->customer->name }}</td>
                        <td><p class="badge {{ $statusColor }}">{{ $lead->leadStatus->name }}</p></td>
                        <td>{{ $lead->leadSource->name }}</td>
                        <td>{{ $lead->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $lead->updated_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <p>Phone: {{ $lead->customer->mobile_no }}</p>
                            <p>Address: {{ $lead->customer->address }}</p>
                        </td>
                        <td>{{ $lead->notes }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
