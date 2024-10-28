@extends('website.master')

@section('content')
<div class="container">
    <h2>{{ $manager->name }} Leads</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Lead ID</th>
                <th>Lead Name</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leads as $lead)
                <tr>
                    <td>{{ $lead->id }}</td>
                    <td>{{ $lead->leadStatus->name }}</td>
                    <td>{{ $lead->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
