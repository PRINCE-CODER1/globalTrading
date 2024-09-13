@extends('website.master')

@section('content')
<div class="container">
    <h1>Create Team</h1>
    <form action="{{ route('teams.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Team Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Team</button>
    </form>
</div>
@endsection
