@extends('website.master')

@section('title', 'Create Godowns')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-2">
            <h4 class="mb-0 d-flex justify-content-between align-items-center">Create Godowns</h4>
            <a href="{{ route('godowns.index') }}" class="btn btn-secondary">
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
                        <a href="{{ route('godowns.index') }}"><i class="bi bi-box me-1 fs-15"></i> Godowns</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create Godowns</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('godowns.store') }}" method="POST">
                @csrf
                
                <!-- Godown Name Field -->
                <div class="mb-3">
                    <label for="godown_name" class="form-label fs-14 text-dark">
                        <i class="bi bi-box me-1"></i> Godown Name
                    </label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="bi bi-box"></i></span>
                        <input type="text" name="godown_name" id="godown_name" class="form-control" placeholder="Enter Godown Name" value="{{ old('godown_name') }}" required>
                        @error('godown_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- User ID Field (Hidden) -->
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                <!-- Branch Field -->
                <div class="mb-3">
                    <label for="branch_id" class="form-label fs-14 text-dark">
                        <i class="bi bi-building me-1"></i> Branch
                    </label>
                    <select name="branch_id" id="branch_id" class="form-control">
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mobile Field -->
                <div class="mb-3">
                    <label for="mobile" class="form-label fs-14 text-dark">
                        <i class="bi bi-phone me-1"></i> Mobile
                    </label>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><i class="bi bi-phone"></i></span>
                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile Number" value="{{ old('mobile') }}" required>
                        @error('mobile')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address Field -->
                <div class="mb-3">
                    <label for="address" class="form-label fs-14 text-dark">
                        <i class="bi bi-geo-alt me-1"></i> Address
                    </label>
                    <textarea name="address" id="address" class="form-control" placeholder="Enter Address" rows="3" required>{{ old('address') }}</textarea>
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
