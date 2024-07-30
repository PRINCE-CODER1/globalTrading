@extends('website.master')

@section('content')
<div class="container">
    <h1>Edit Users</h1>
    <form method="POST" action="{{ route('users.update', $users->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $users->name) }}">
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $users->email) }}">
            @error('email')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">Password</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="permissions">roles</label>
            @foreach($roles as $role)
                <div>
                    <input type="checkbox" {{ $hasRoles->contains($role->id) ? 'checked' : '' }} id="role-{{ $role->id }}" name="role[]" value="{{ $role->id }}"
                           >
                    <label for="role-{{ $role->id }}">{{ $role->name }}</label>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection
