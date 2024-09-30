@extends('website.master')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-2">
            <h4 class="mb-0">Create Child Category</h4>
            <a href="{{ route('child-categories.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-chevron-left me-1"></i> Back
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('child-categories.store') }}" method="POST">
                @csrf

                <!-- Parent Category Field -->
                <div class="mb-3">
                    <label for="parent_category_id" class="form-label fs-14 text-dark">Parent Category</label>
                    <select name="parent_category_id" id="parent_category_id" class="form-select" required>
                        <option value="" selected disabled>Select Parent Category</option>
                        @foreach($parentCategories as $parentCategory)
                            <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_category_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label fs-14 text-dark">Category Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-menu-search-line"></i></span>
                        <input name="name" type="text" class="form-control" id="name" placeholder="Enter category name" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Category Description Field -->
                <div class="mb-3">
                    <label for="description" class="form-label fs-14 text-dark">Category Description</label>
                    <div class="input-group">
                        <textarea id="description" name="description" class="form-control" placeholder="Enter category description">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-secondary mt-3">
                    <i class="bi bi-check2 me-1"></i>  Create Category
                </button>
            </form>
        </div>
    </div>
</div>
@endsection