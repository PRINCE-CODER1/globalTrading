@extends('website.master')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-2">
            <h4 class="mb-0 d-flex justify-content-between align-items-center">Create Taxes</h4>
            <a href="{{ route('taxes.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <!-- Breadcrumb Navigation -->
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('taxes.index') }}"><i class="ti ti-apps me-1 fs-15"></i>Taxes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Taxes</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('taxes.store') }}" method="POST">
                @csrf

                <!-- Tax Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label fs-14 text-dark">Tax Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-user-line"></i></span>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Tax Name" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tax Value Field -->
                <div class="mb-3">
                    <label for="value" class="form-label fs-14 text-dark">Value</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-hand-coin-line"></i></span>
                        <input type="number" name="value" class="form-control" id="value" step="0.01" placeholder="Enter Value" value="{{ old('value') }}" required>
                        @error('value')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-secondary mt-3">
                    <i class="bi bi-check2 me-1"></i> Submit
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
