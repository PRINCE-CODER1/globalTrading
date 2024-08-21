@extends('website.master')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-2">
            <h4 class="mb-0 d-flex justify-content-between align-items-center">Create Cust/Supp</h4>
            <a href="{{ route('customer-supplier.index') }}" class="btn btn-outline-secondary">
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
                    <li class="breadcrumb-item"><a href="{{ route('customer-supplier.index') }}"><i class="bi bi-person-lines-fill me-1 fs-15"></i>Cust/Supp</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Cust/Supp</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <!-- Create Form -->
    <div class="row d-flex justify-content-center">
        <div class="container">
            <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
                <form action="{{ route('customer-supplier.store') }}" method="POST">
                    @csrf
    
                    <!-- Form Fields -->
                    <div class="row">
                        <div class="col-md-6 mb-3 p-2">
                            <label for="name" class="form-label fs-14 text-dark">Name<sup class="text-danger fs-6">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-person"></i></div>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter name" value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 p-2">
                            <label for="mobile_no" class="form-label fs-14 text-dark">Mobile No<sup class="text-danger fs-6">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-telephone"></i></div>
                                <input type="text" class="form-control @error('mobile_no') is-invalid @enderror" id="mobile_no" name="mobile_no" placeholder="Enter mobile" value="{{ old('mobile_no') }}" required>
                                @error('mobile_no')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-3 p-2">
                        <label for="address" class="form-label fs-14 text-dark">Address</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-geo-alt"></i></div>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Enter address" value="{{ old('address') }}">
                            @error('address')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
    
                    <div class="mb-3 p-2">
                        <label for="customer_supplier" class="form-label fs-14 text-dark">Customer/Supplier<sup class="text-danger fs-6">*</sup></label>
                        <select class="form-control @error('customer_supplier') is-invalid @enderror" id="customer_supplier" name="customer_supplier" required>
                            <option value="">Select</option>
                            <option value="Only Supplier" {{ old('customer_supplier') == 'Only Supplier' ? 'selected' : '' }}>Only Supplier</option>
                            <option value="Only Customer" {{ old('customer_supplier') == 'Only Customer' ? 'selected' : '' }}>Only Customer</option>
                            <option value="Both Supplier & Customer" {{ old('customer_supplier') == 'Both Supplier & Customer' ? 'selected' : '' }}>Both Supplier & Customer</option>
                        </select>
                        @error('customer_supplier')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
    
                    <div class="row">
                        <div class="col-md-6 mb-3 p-2">
                            <label for="gst_no" class="form-label fs-14 text-dark">GST No<sup class="text-danger fs-6">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-hash"></i></div>
                                <input type="text" class="form-control @error('gst_no') is-invalid @enderror" id="gst_no" name="gst_no" placeholder="Enter GST number" value="{{ old('gst_no') }}">
                                @error('gst_no')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 p-2">
                            <label for="pan_no" class="form-label fs-14 text-dark">PAN No<sup class="text-danger fs-6">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-card-text"></i></div>
                                <input type="text" class="form-control @error('pan_no') is-invalid @enderror" id="pan_no" name="pan_no" placeholder="Enter PAN number" value="{{ old('pan_no') }}">
                                @error('pan_no')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-md-6 mb-3 p-2">
                            <label for="country" class="form-label fs-14 text-dark">Country<sup class="text-danger fs-6">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-flag"></i></div>
                                <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" placeholder="Enter country" value="{{ old('country', 'India') }}" required>
                                @error('country')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 p-2">
                            <label for="state" class="form-label fs-14 text-dark">State<sup class="text-danger fs-6">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-geo-alt"></i></div>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" placeholder="Enter state" value="{{ old('state') }}" required>
                                @error('state')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
    
                    <div class="mb-3 p-2">
                        <label for="city" class="form-label fs-14 text-dark">City<sup class="text-danger fs-6">*</sup></label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-building"></i></div>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" placeholder="Enter city" value="{{ old('city') }}" required>
                            @error('city')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
    
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-secondary">
                        <i class="bi bi-save me-1"></i> Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
