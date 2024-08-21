@extends('website.master')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-2">
            <h4 class="mb-0 d-flex justify-content-between align-items-center">Create Stock Category</h4>
            <a href="{{ route('stocks-categories.index') }}" class="btn btn-outline-secondary btn-wave float-end">
                <i class="bi bi-chevron-left me-1"></i> Back
            </a>
        </div>
    </div>

    <!-- Breadcrumb Navigation -->
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('stocks-categories.index') }}"><i class="bi bi-box-seam me-1 fs-15"></i>Stock Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Stock Category</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('stocks-categories.store') }}" method="POST">
                @csrf
                
                <!-- Category Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label fs-14 text-dark">Category Name</label>
                    <div class="input-group">
                        <span class="input-group-text" id="inputGroupPrepend"><i class="ri-menu-search-line"></i></span>
                        <input name="name" type="text" class="form-control" id="name" placeholder="Enter category name" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Parent Category Field -->
                <div class="mb-3">
                    <label for="parent_id" class="form-label fs-14 text-dark">Parent Category</label>
                    <div class="input-group">
                        <select id="parent_id" name="parent_id" class="form-control">
                            <option value="">None</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_id')
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
