@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Edit Branch</h2>
            <a href="{{ route('branches.index') }}" class="btn btn-outline-secondary">
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
                        <a href="javascript:void(0);"><i class="bi bi-house-door me-1 fs-15"></i>Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('branches.index') }}"><i class="bi bi-geo-alt me-1 fs-15"></i>Branches</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Branch</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('branches.update', $branch->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Branch Name Field -->
                <div class="mb-3">
                    <label for="branch_name" class="form-label fs-14 text-dark">
                        <i class="bi bi-building me-1"></i> Branch Name
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                        <input value="{{ old('name', $branch->name) }}" type="text" name="name" class="form-control" id="branch_name" placeholder="Enter branch name" required>
                    </div>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User ID Field (Hidden) -->
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                <!-- Mobile Field -->
                <div class="mb-3">
                    <label for="mobile" class="form-label fs-14 text-dark">
                        <i class="bi bi-phone me-1"></i> Mobile
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-phone"></i></span>
                        <input value="{{ old('mobile', $branch->mobile) }}" type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter mobile number" required>
                    </div>
                    @error('mobile')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address Field -->
                <div class="mb-3">
                    <label for="address" class="form-label fs-14 text-dark">
                        <i class="bi bi-geo-alt me-1"></i> Address
                    </label>
                    <textarea name="address" class="form-control" id="address" rows="3" placeholder="Enter address" required>{{ old('address', $branch->address) }}</textarea>
                    @error('address')
                        <p class="text-danger">{{ $message }}</p>
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
