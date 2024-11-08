@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-2">
            <h2 class="mb-0 d-flex justify-content-center text-center align-items-center">Edit Leads Type</h2>
            <a href="{{ route('leads-types.index') }}" class="btn btn-secondary">
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
                        <a href="{{ route('leads-types.index') }}"><i class="bi bi-geo-alt me-1 fs-15"></i>Leads Type</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Lead Type</li>
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
            <form action="{{ route('leads-types.update', $lead->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="branch_name" class="form-label fs-14 text-dark">
                        <i class="bi bi-building me-1"></i> Name
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $lead->name) }}" required>
                    </div>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
              
                <div class="mb-3">
                    <label for="details" class="form-label fs-14 text-dark">
                        <i class="bi bi-geo-alt me-1"></i> Details
                    </label>
                    <textarea name="details" id="details" class="form-control @error('details') is-invalid @enderror">{{ old('details', $lead->details) }}</textarea>
                    @error('details')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-secondary"><i class="ri-add-circle-line me-1"></i> Update Lead Type</button>
            </form>
        </div>
    </div>
</div>
@endsection