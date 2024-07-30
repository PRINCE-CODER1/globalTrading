@extends('website.master')

@section('content')
<div class="container">
    <h1>Edit Permission</h1>
    <form method="POST" action="{{ route('permissions.update', $permissions->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $permissions->name) }}">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection
