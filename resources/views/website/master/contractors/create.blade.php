@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-2">
            <h2 class="mb-0 d-flex justify-content-center text-center align-items-center">Create Contractor</h2>
            <a href="{{ route('contractor.index') }}" class="btn btn-secondary">
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
                        <a href="{{ route('contractor.index') }}"><i class="bi bi-geo-alt me-1 fs-15"></i>Contractor</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create Contractor</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('contractor.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="branch_name" class="form-label fs-14 text-dark">
                        <i class="bi bi-building me-1"></i> Name
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                        <input value="{{ old('name') }}" type="text" name="name" class="form-control" id="branch_name" placeholder="Enter Name" required>
                    </div>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                {{-- <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div> --}}
                <div class="mb-3">
                    <label for="details" class="form-label fs-14 text-dark">
                        <i class="bi bi-geo-alt me-1"></i> Details
                    </label>
                    <textarea name="details" class="form-control" id="details" rows="3" placeholder="Enter details" required>{{ old('details') }}</textarea>
                    @error('details')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
        
                {{-- <div class="mb-3">
                    <label for="details" class="form-label">Details</label>
                    <textarea name="details" id="details" class="form-control"></textarea>
                </div> --}}
                <button type="submit" class="btn btn-secondary"><i class="ri-add-circle-line me-1"></i> Create Contractor</button>
            </form>
        </div>
    </div>
</div>
@endsection