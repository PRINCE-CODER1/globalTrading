@extends('website.master')

@section('content')
<div class="container p-4">
    <h3 class="mb-4">Employee Daily Activity Reports</h3>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Employee Id</th>
                                        <th>Total DAR Reports</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->dars_count }}</td>
                                            <td>
                                                <a href="{{ route('user-reports', ['userId' => $user->id]) }}" class="btn btn-secondary"><i class="ri-eye-fill"></i> View Reports</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
