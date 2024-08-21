@extends('website.master')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Edit Lead Source</h4>
            <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-chevron-left me-1"></i> Back
            </a>
        </div>
    </div>

    <!-- Breadcrumb Navigation -->
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="bi bi-house-door me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('leads.index') }}"><i class="bi bi-person-lines-fill me-1 fs-15"></i>Leads</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Lead</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Edit Lead Form -->
    <div class="row d-flex justify-content-center">
        <div class="col-12 mt-3 mb-5 bg-white p-5 shadow">
            <form action="{{ route('leads.update', $leadSource->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label fs-14 text-dark">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $leadSource->name) }}" required>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description Field -->
                <div class="mb-3">
                    <label for="description" class="form-label fs-14 text-dark">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description', $leadSource->description) }}</textarea>
                    @error('description')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Toggle Switch -->
                <div class="mb-3">
                    <label class="form-label fs-14 text-dark me-3" for="active">Active</label>
                    <input type="hidden" name="active" value="0">
                    <label class="switch">
                        <input type="checkbox" id="active" name="active" value="1" {{ old('active', $leadSource->active ?? false) ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-pencil-square me-1"></i> Update
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
