@extends('website.master')
@section('content')
<div class="container">
    <h2>Edit Branch</h2>
    <form action="{{ route('branches.update', $branch->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Branch Name</label>
            <input value="{{ old('name', $branch->name) }}" type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="user_id">User</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}"{{ old('user_id', $branch->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input type="text" value="{{ old('mobile', $branch->mobile) }}" name="mobile" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" class="form-control" required>{{ old('address', $branch->address) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection