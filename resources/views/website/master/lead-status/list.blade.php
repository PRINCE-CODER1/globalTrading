@extends('website.master')

@section('content')
<div>
    @livewire('master.lead-status-list')
</div>
{{-- <div class="container">
    <h4>Lead Status</h4>

    <a href="{{ route('leads-status.create') }}" class="btn btn-primary">Create Lead</a>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leads as $lead)
                <tr>
                    <td>{{ $lead->name }}</td>
                    <td>{{ $lead->status }}</td>
                    <td>{{ $lead->details }}</td>
                    <td>
                        <a href="{{ route('leads-status.edit', $lead->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('leads-status.destroy', $lead->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this lead?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No Leads Available</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $leads->links('custom-pagination-links') }}
</div> --}}
@endsection
