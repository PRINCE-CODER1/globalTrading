@extends('website.master')
@section('content')

    {{-- <a href="{{route('visits.create')}}" class="btn btn-secondary">Create</a>
    <div class="container">
        <h1>Visits</h1>
    
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    
        <a href="{{ route('visits.create') }}" class="btn btn-primary mb-3">Add New Visit</a>
    
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Visit Date</th>
                    <th>Location</th>
                    <th>Purpose</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($visits as $visit)
                    <tr>
                        <td>{{ $visit->product->product_name }}</td>
                        <td>{{ $visit->visit_date->format('Y-m-d') }}</td>
                        <td>{{ $visit->location }}</td>
                        <td>{{ $visit->purpose }}</td>
                        <td>
                            <a href="{{ route('visits.edit', $visit) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('visits.destroy', $visit) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <!-- Pagination Links -->
        {{ $visits->links() }}
    </div> --}}

    <div>
        @livewire('master.visits')
    </div>

@endsection