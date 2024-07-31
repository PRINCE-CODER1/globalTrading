@extends('website.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-3">
            <h4 class="mb-0">Create User</h4>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 my-5 bg-white p-5 shadow">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label fs-14 text-dark">Name</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-user-line"></i></div>
                        <input value="{{ old('name') }}" type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fs-14 text-dark">Email</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-mail-line"></i></div>
                        <input value="{{ old('email') }}" name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter email" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fs-14 text-dark">Password</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-lock-line"></i></div>
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="roles" class="form-label">Roles</label>
                    <select id="roles" name="role[]" class="form-control @error('role') is-invalid @enderror" >
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ in_array($role->id, old('role', [])) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-secondary">Create User</button>
            </form> 
        </div>
    </div>
</div>
@endsection
