@extends('website.master')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-2">
            <h4 class="mb-0 d-flex justify-content-between align-items-center">Create Workshop</h4>
            <a href="{{ route('workshops.index') }}" class="btn btn-outline-secondary btn-wave float-end">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <!-- Breadcrumb Navigation -->
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="bi bi-house-door me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('workshops.index') }}"><i class="bi bi-gear me-1 fs-15"></i>Workshops</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Workshop</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('workshops.store') }}" method="POST">
                @csrf

                <!-- Workshop Name Field -->
                <div class="mb-3">
                    <label for="workshop_name" class="form-label fs-14 text-dark">
                        <i class="bi bi-tools me-1"></i> Workshop Name
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-tools"></i></span>
                        <input value="{{ old('name') }}" type="text" name="name" class="form-control" id="workshop_name" placeholder="Enter workshop name" required>
                    </div>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Branch Field -->
                <div class="mb-3">
                    <label for="branch_id" class="form-label fs-14 text-dark">
                        <i class="bi bi-building me-1"></i> Branch
                    </label>
                    <select class="form-select" id="branch_id" name="branch_id" aria-label="Select branch" required>
                        <option value="" disabled selected>Select a branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-save me-1"></i> Save
                </button>
            </form>
        </div>
    </div>
    
    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
