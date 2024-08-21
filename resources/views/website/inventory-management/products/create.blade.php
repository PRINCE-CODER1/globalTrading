@extends('website.master')
@section('title', 'Create Product')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mt-5 mb-2">
                <h2 class="mb-0 d-flex justify-content-between align-items-center">Create Product</h2>
                <a href="{{ route('products.index') }}" type="button" class="btn btn-outline-secondary"><i class="bi bi-chevron-left me-1"></i> Back</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}"><i class="ri-product-hunt-line"></i>Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Products</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="container">
                <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name<sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-box"></i></div>
                                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="product_description" class="form-label">Product Description</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-file-text"></i></div>
                                <textarea class="form-control" id="product_description" name="product_description">{{ old('product_description') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="series_id">Series</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-tag"></i></div>
                                <select name="series_id" id="series_id" class="form-control">
                                    <option value="">Select Series</option>
                                    @foreach ($series as $ser)
                                        <option value="{{ $ser->id }}">{{ $ser->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="product_category_id" class="form-label">Product Category<sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-folder"></i></div>
                                <select class="form-control" id="product_category_id" name="product_category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tax" class="form-label">Tax</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-percent"></i></div>
                                <select class="form-control" id="tax" name="tax" required>
                                    @foreach($tax as $tax)
                                        <option value="{{ $tax->value }}">{{ $tax->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="product_model" class="form-label">Product Model</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="ri-archive-stack-line"></i></div>
                                <input type="text" class="form-control" id="product_model" name="product_model" value="{{ old('product_model') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="hsn_code" class="form-label">HSN Code<sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-bar-chart"></i></div>
                                <input type="text" class="form-control" id="hsn_code" name="hsn_code" value="{{ old('hsn_code') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price<sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-cash"></i></div>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="product_code" class="form-label">Product Code<sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-code-slash"></i></div>
                                <input type="text" class="form-control" id="product_code" name="product_code" value="{{ old('product_code') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="opening_stock" class="form-label">Opening Stock<sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-box-seam"></i></div>
                                <input type="number" class="form-control" id="opening_stock" name="opening_stock" value="{{ old('opening_stock') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="reorder_stock" class="form-label">Re-order Stock<sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-arrow-repeat"></i></div>
                                <input type="number" class="form-control" id="reorder_stock" name="reorder_stock" value="{{ old('reorder_stock') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="branch_id" class="form-label">Select Branch<sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-building"></i></div>
                                <select class="form-control" id="branch_id" name="branch_id" required>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="godown_id" class="form-label">Select Godown<sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="ri-community-line"></i></div>
                                <select class="form-control" id="godown_id" name="godown_id" required>
                                    @foreach($godowns as $godown)
                                        <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="unit_id" class="form-label">Select Unit<sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="ri-formula"></i></div>
                                <select class="form-control" id="unit_id" name="unit_id" required>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->formula_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-image"></i></div>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-secondary">
                            <i class="bi bi-check2 me-1"></i> Create
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
