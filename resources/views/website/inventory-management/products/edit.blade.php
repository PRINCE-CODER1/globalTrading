@extends('website.master')
@section('title', 'Edit Product')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mt-5">
                <h2 class="mb-0">Edit Product</h2>
                <a href="{{ route('products.index') }}" type="button" class="btn btn-outline-secondary"><i class="bi bi-chevron-left me-1"></i> Back</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="bi bi-house-door me-1 fs-15"></i>Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}"><i class="ri-product-hunt-line"></i>Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name<sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-box"></i></span>
                            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}" required>
                        </div>
                    </div>

                    <!-- Product Description -->
                    <div class="mb-3">
                        <label for="product_description" class="form-label">Product Description</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-file-text"></i></span>
                            <textarea class="form-control" id="product_description" name="product_description">{{ $product->product_description }}</textarea>
                        </div>
                    </div>

                    <!-- Series -->
                    <div class="mb-3">
                        <label for="series_id" class="form-label">Series</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-tag"></i></span>
                            <select name="series_id" id="series_id" class="form-control">
                                <option value="">Select Series</option>
                                @foreach ($series as $ser)
                                    <option value="{{ $ser->id }}" {{ $product->series_id == $ser->id ? 'selected' : '' }}>
                                        {{ $ser->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Product Category -->
                    <div class="mb-3">
                        <label for="product_category_id" class="form-label">Product Category<sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-folder"></i></span>
                            <select class="form-control" id="product_category_id" name="product_category_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->product_category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tax -->
                    <div class="mb-3">
                        <label for="tax" class="form-label">Tax</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-percent"></i></span>
                            <input type="number" step="0.01" class="form-control" id="tax" name="tax" value="{{ $product->tax }}">
                        </div>
                    </div>

                    <!-- Product Model -->
                    <div class="mb-3">
                        <label for="product_model" class="form-label">Product Model</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-archive-stack-line"></i></span>
                            <input type="text" class="form-control" id="product_model" name="product_model" value="{{ $product->product_model }}">
                        </div>
                    </div>

                    <!-- HSN Code -->
                    <div class="mb-3">
                        <label for="hsn_code" class="form-label">HSN Code<sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-bar-chart"></i></span>
                            <input type="text" class="form-control" id="hsn_code" name="hsn_code" value="{{ $product->hsn_code }}" required>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price<sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-cash"></i></span>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                        </div>
                    </div>

                    <!-- Product Code -->
                    <div class="mb-3">
                        <label for="product_code" class="form-label">Product Code<sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-code-slash"></i></span>
                            <input type="text" class="form-control" id="product_code" name="product_code" value="{{ $product->product_code }}" required>
                        </div>
                    </div>

                    <!-- Opening Stock -->
                    <div class="mb-3">
                        <label for="opening_stock" class="form-label">Opening Stock<sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                            <input type="number" class="form-control" id="opening_stock" name="opening_stock" value="{{ $product->opening_stock }}" required>
                        </div>
                    </div>

                    <!-- Re-order Stock -->
                    <div class="mb-3">
                        <label for="reorder_stock" class="form-label">Re-order Stock<sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-arrow-repeat"></i></span>
                            <input type="number" class="form-control" id="reorder_stock" name="reorder_stock" value="{{ $product->reorder_stock }}" required>
                        </div>
                    </div>

                    <!-- Branch -->
                    <div class="mb-3">
                        <label for="branch_id" class="form-label">Select Branch<sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                            <select class="form-control" id="branch_id" name="branch_id" required>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $product->branch_id == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Godown -->
                    <div class="mb-3">
                        <label for="godown_id" class="form-label">Select Godown<sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-community-line"></i></span>
                            <select class="form-control" id="godown_id" name="godown_id" required>
                                @foreach($godowns as $godown)
                                    <option value="{{ $godown->id }}" {{ $product->godown_id == $godown->id ? 'selected' : '' }}>
                                        {{ $godown->godown_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Unit -->
                    <div class="mb-3">
                        <label for="unit_id" class="form-label">Select Unit<sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-formula"></i></span>
                            <select class="form-control" id="unit_id" name="unit_id" required>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ $product->unit_id == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->formula_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-image"></i></span>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-secondary mt-3">
                        <i class="bi bi-pencil-square me-1"></i> Update
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
