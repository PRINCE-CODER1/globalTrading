@extends('website.master')

@section('content')
<div class="container">
    <h1>Edit Stock Category</h1>
    <form action="{{ route('stocks-categories.update', $stockCategory->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="parent_id">Parent Category</label>
            <select id="parent_id" name="parent_id" class="form-control">
                <option value="">None</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $stockCategory->parent_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $stockCategory->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Category Description</label>
            <textarea id="description" name="description" class="form-control">{{ old('description', $stockCategory->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
        <a href="{{ route('stocks-categories.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection
