<div class="container">
    <h1>Lead List</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <input type="text" wire:model.live="search" class="form-control" placeholder="Search leads...">
    </div>

    <a href="{{ route('agent.leads.create') }}" class="btn btn-primary mb-3">Create New Lead</a>

    @if($leads->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Source</th>
                    <th>Segment</th>
                    <th>Sub-Segment</th>
                    <th>Expected Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leads as $lead)
                    <tr>
                        <td>{{ $lead->customer->name ?? 'N/A' }}</td>
                        <td>{{ $lead->leadStatus->name ?? 'N/A' }}</td>
                        <td>{{ $lead->leadSource->name ?? 'N/A' }}</td>
                        <td>{{ $lead->segment->name ?? 'N/A' }}</td>
                        <td>{{ optional($lead->subSegment)->name ?? 'N/A' }}</td>
                        <td>{{ $lead->expected_date }}</td>
                        <td>
                            <a href="{{ route('agent.leads.edit', $lead->id) }}" class="btn btn-warning">Edit</a>
                            <button wire:click="delete({{ $lead->id }})" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $leads->links() }}
    @else
        <p>No leads found.</p>
    @endif
</div>
