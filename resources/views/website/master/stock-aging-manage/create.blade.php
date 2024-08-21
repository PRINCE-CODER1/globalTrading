@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-2">
            <h2 class="mb-0 d-flex justify-content-between align-items-center">Create Stock Aging</h2>
            <a href="{{ route('age_categories.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"><i class="bi bi-house-door me-1 fs-15"></i> Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('age_categories.index') }}"><i class="bi bi-clock me-1 fs-15"></i> Stock Aging</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create Stock Aging Master</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('age_categories.store') }}" method="POST">
                @csrf

                <!-- Title Field -->
                <div class="mb-3">
                    <label for="title" class="form-label fs-14 text-dark">
                        <i class="bi bi-file-text me-1"></i> Title <sup class="text-danger">*</sup>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-file-text"></i></span>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Days Field -->
                <div class="mb-3">
                    <label for="days" class="form-label fs-14 text-dark">
                        <i class="bi bi-calendar me-1"></i> Days <sup class="text-danger">*</sup>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                        <input type="text" name="days" id="days" class="form-control" required>
                    </div>
                    @error('days')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-secondary mt-3">
                    <i class="bi bi-check-circle me-1"></i> Create
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
