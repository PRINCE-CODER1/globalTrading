@extends('website.master')

@section('content')
<div class="container">
    <h1>Edit Team</h1>
    <form action="{{ route('teams.update', $team) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Team Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $team->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Team</button>
    </form>
</div>
@endsection
