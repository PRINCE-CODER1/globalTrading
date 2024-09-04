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
                    @livewire('master.product-form')
                </div>
            </div>
        </div>
    </div>
@endsection
