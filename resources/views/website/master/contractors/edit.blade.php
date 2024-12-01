@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-2">
            <h2 class="mb-0 d-flex justify-content-center text-center align-items-center">Edit Contractor</h2>
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
                    <li class="breadcrumb-item active" aria-current="page">Edit Contractor</li>
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
            <form action="{{ route('contractor.update', $lead->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="branch_name" class="form-label fs-14 text-dark">
                        <i class="bi bi-building me-1"></i> Name
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                        <input value="{{ old('name', $lead->name) }}" type="text" name="name" class="form-control" id="name" placeholder="Enter Name" required>
                    </div>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                 <!-- Address Field -->
                 <div class="mb-3">
                    <label for="address" class="form-label fs-14 text-dark">
                        <i class="bi bi-geo-alt me-1"></i> Address
                    </label>
                    <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror"
                              rows="3">{{ old('address', $lead->address) }}</textarea>
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Contractor Type -->
                <div class="mb-3">
                    <label class="form-label fs-14 text-dark">
                        <i class="bi bi-tools me-1"></i> Contractor Type
                    </label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="contractor_type" id="hvac" 
                                   value="HVAC" {{ old('contractor_type', $lead->contractor_type) == 'HVAC' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="hvac">HVAC</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="contractor_type" id="plumbing" 
                                   value="Plumbing" {{ old('contractor_type', $lead->contractor_type) == 'Plumbing' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="plumbing">Plumbing</label>
                        </div>
                    </div>
                    @error('contractor_type')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        
                <button type="submit" class="btn btn-secondary"><i class="ri-add-circle-line me-1"></i> Update Contractor</button>
            </form>
        </div>
    </div>
</div>
@endsection