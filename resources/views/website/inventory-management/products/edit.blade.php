@extends('website.master')
@section('title', 'Edit Product')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mt-5">
                <h2 class="mb-0">Edit Product</h2>
                <a href="{{route('products.index')}}" type="button" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('products.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Products</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="container">
                <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name *</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_description" class="form-label">Product Description</label>
                            <textarea class="form-control" id="product_description" name="product_description">{{ $product->product_description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="series_id">Series</label>
                            <select name="series_id" id="series_id" class="form-control">
                                <option value="">Select Series</option>
                                @foreach ($series as $ser)
                                    <option value="{{ $ser->id }}" {{ $product->series_id == $ser->id ? 'selected' : '' }}>
                                        {{ $ser->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="product_category_id" class="form-label">Product Category *</label>
                            <select class="form-control" id="product_category_id" name="product_category_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->product_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tax" class="form-label">Tax</label>
                            <input type="number" step="0.01" class="form-control" id="tax" name="tax" value="{{ $product->tax }}">
                        </div>
                        <div class="mb-3">
                            <label for="product_model" class="form-label">Product Model</label>
                            <input type="text" class="form-control" id="product_model" name="product_model" value="{{ $product->product_model }}">
                        </div>
                        <div class="mb-3">
                            <label for="hsn_code" class="form-label">HSN Code *</label>
                            <input type="text" class="form-control" id="hsn_code" name="hsn_code" value="{{ $product->hsn_code }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price *</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_code" class="form-label">Product Code *</label>
                            <input type="text" class="form-control" id="product_code" name="product_code" value="{{ $product->product_code }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="opening_stock" class="form-label">Opening Stock *</label>
                            <input type="number" class="form-control" id="opening_stock" name="opening_stock" value="{{ $product->opening_stock }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="reorder_stock" class="form-label">Re-order Stock *</label>
                            <input type="number" class="form-control" id="reorder_stock" name="reorder_stock" value="{{ $product->reorder_stock }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="branch_id" class="form-label">Select Branch *</label>
                            <select class="form-control" id="branch_id" name="branch_id" required>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $product->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="godown_id" class="form-label">Select Godown *</label>
                            <select class="form-control" id="godown_id" name="godown_id" required>
                                @foreach($godowns as $godown)
                                    <option value="{{ $godown->id }}" {{ $product->godown_id == $godown->id ? 'selected' : '' }}>{{ $godown->godown_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="unit_id" class="form-label">Select Unit *</label>
                            <select class="form-control" id="unit_id" name="unit_id" required>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ $product->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->formula_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <button type="submit" class="btn btn-secondary">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection