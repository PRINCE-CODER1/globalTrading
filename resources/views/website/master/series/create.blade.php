@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-2">
            <h2 class="mb-0 d-flex justify-content-between align-items-center">Create Series</h2>
            <a href="{{ route('series.index') }}" class="btn btn-outline-secondary">
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
                        <a href="{{ route('series.index') }}"><i class="bi bi-list-ul me-1 fs-15"></i> Series</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create Series</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('series.store') }}" method="POST">
                @csrf

                <!-- Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label fs-14 text-dark">
                        <i class="bi bi-tag me-1"></i> Name <sup class="text-danger">*</sup>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-tag"></i></span>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description Field -->
                <div class="mb-3">
                    <label for="description" class="form-label fs-14 text-dark">
                        <i class="bi bi-file-earmark-text me-1"></i> Description
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Discount Rate Field -->
                <div class="mb-3">
                    <label for="discount_rate" class="form-label fs-14 text-dark">
                        <i class="bi bi-percent me-1"></i> Discount Rate (%) 
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-percent"></i></span>
                        <input type="number" name="discount_rate" id="discount_rate" class="form-control" step="0.01" min="0" max="100" value="{{ old('discount_rate') }}">
                    </div>
                    @error('discount_rate')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tax Rate Field -->
                <div class="mb-3">
                    <label for="tax_rate" class="form-label fs-14 text-dark">
                        <i class="bi bi-percent me-1"></i> Tax Rate (%)
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-percent"></i></span>
                        <input type="number" name="tax_rate" id="tax_rate" class="form-control" step="0.01" min="0" max="100" value="{{ old('tax_rate') }}">
                    </div>
                    @error('tax_rate')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-save me-1"></i> Save
                </button>
            </form>
        </div>
    </div>
</div>
@endsection


    {{-- <div class="mb-3">
        <label for="dismantling_required" class="form-label fs-14 text-dark me-3">Dismantling</label>
        <label class="switch">
            <input type="checkbox" name="dismantling_required" id="dismantling_required" value="1">
            <span class="slider round"></span>
        </label>
        @error('dismantling_required')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div> --}}