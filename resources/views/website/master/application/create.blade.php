@extends('website.master')

@section('content')
<div>
    <a href="{{route('application.index')}}" class="btn btn-secondary btn-sm">back</a>
</div>
<form action="{{ route('application.store') }}" method="POST">
    @csrf

    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
    </div>

    <div>
       <!-- User ID Field (Hidden) -->
       <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
    </div>

    <button type="submit">Create</button>
    <a href="{{ route('application.index') }}">Back</a>
</form>
@endsection