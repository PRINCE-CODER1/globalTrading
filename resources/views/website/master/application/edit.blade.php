@extends('website.master')

@section('content')
<div>
    <a href="{{route('application.index')}}" class="btn btn-secondary btn-sm">edit</a>
</div>
<form action="{{ route('application.update', $application->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ old('name', $application->name) }}" required>
    </div>

    <div>
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
     </div>

    <button type="submit">Update</button>
    <a href="{{ route('application.index') }}">Back</a>
</form>
@endsection