@extends('website.master')

@section('title', 'Create Sales')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-2">
            <h2 class="mb-0 d-flex justify-content-between align-items-center">Create Sales</h2>
            <a href="{{ route('sale-types.index') }}" type="button" class="btn btn-outline-secondary">
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
                        <a href="{{ route('sale-types.index') }}"><i class="bi bi-tags me-1 fs-15"></i> Sale Types</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create Sales</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('sale-types.store') }}" method="POST">
                @csrf
                
                <!-- Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label fs-14 text-dark">
                        <i class="bi bi-person me-1"></i> Name
                    </label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description Field -->
                <div class="mb-3">
                    <label for="description" class="form-label fs-14 text-dark">
                        <i class="bi bi-info-circle me-1"></i> Description
                    </label>
                    <textarea name="description" id="description" class="form-control" placeholder="Enter description">{{ old('description') }}</textarea>
                </div>
                
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-save me-1"></i> Create
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
