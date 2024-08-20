@extends('website.master')

@section('content')
<h1>Age Categories</h1>

<a href="{{ route('age_categories.create') }}">Add New Age Category</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Days</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->title }}</td>
                <td>{{ $category->days }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
