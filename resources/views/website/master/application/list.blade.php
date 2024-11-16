@extends('website.master')

@section('content')
<div>
    {{-- @livewire('master') --}}
    <a href="{{route('application.create')}}" class="btn btn-secondary btn-sm">Create</a>
</div>
<ul>
    @foreach ($applications as $application)
        <li>
            {{ $application->name }}
            <a href="{{ route('application.edit', $application->id) }}">Edit</a>
            <form action="{{ route('application.destroy', $application->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </li>
    @endforeach
</ul>
@endsection