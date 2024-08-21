@extends('website.master')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h4 class="mb-0">Edit Stock Category</h4>
            <a href="{{ route('stocks-categories.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-chevron-left me-1"></i> Back
            </a>
        </div>
    </div>

    <!-- Breadcrumb Navigation -->
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="bi bi-house-door me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('stocks-categories.index') }}"><i class="bi bi-box-seam me-1 fs-15"></i>Stock Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Stock Category</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Edit Form Section -->
    <div class="row d-flex justify-content-center">
        <div class="col-12 mt-3 mb-5 bg-white p-5 shadow">
            <form action="{{ route('stocks-categories.update', $stockCategory->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Category Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label fs-14 text-dark">Category Name</label>
                    <div class="input-group">
                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-tag"></i></span>
                        <input value="{{ old('name', $stockCategory->name) }}" name="name" type="text" class="form-control" placeholder="Enter category name" id="name">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Parent Category Field -->
                <div class="mb-3">
                    <label for="parent_id" class="form-label fs-14 text-dark">Parent Category</label>
                    <select id="parent_id" name="parent_id" class="form-control">
                        <option value="">None</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $stockCategory->parent_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Description Field -->
                <div class="mb-3">
                    <label for="description" class="form-label fs-14 text-dark">Category Description</label>
                    <textarea id="description" name="description" class="form-control">{{ old('description', $stockCategory->description) }}</textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-check2 me-1"></i> Update Category
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
