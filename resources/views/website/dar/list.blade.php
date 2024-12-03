@extends('website.master')

@section('content')
<div class="container p-4">
    <h3 class="mb-4">Employee Daily Activity Reports</h3>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Total DAR Reports</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->dars_count }}</td>
                    <td>
                        <a href="{{ route('user-reports', ['userId' => $user->id]) }}" class="btn btn-info">View Reports</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
