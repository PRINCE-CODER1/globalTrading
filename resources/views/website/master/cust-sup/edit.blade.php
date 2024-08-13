@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 ">
            <h4 class="mb-0">
                Edit Cust/Supp
            </h4>
            <a href="{{route('customer-supplier.index')}}" type="button" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('customer-supplier.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Cust/Supp</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Cust/Supp</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="container">
            <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
                <form action="{{ route('customer-supplier.update', $customerSupplier->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Name Field -->
                        <div class="mb-3 col-md-6 p-2">
                            <label for="form-text1" class="form-label fs-14 text-dark">Name<sup class="text-danger fs-6">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="ri-user-line"></i></div>
                                <input value="{{ old('name', $customerSupplier->name) }}" type="text" name="name" class="form-control" id="form-text1" placeholder="enter name">
                                @error('name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Mobile No Field -->
                        <div class="mb-3 col-md-6 p-2">
                            <label for="form-text2" class="form-label fs-14 text-dark">Mobile No<sup class="text-danger fs-6">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="ri-phone-line"></i></div>
                                <input value="{{ old('mobile_no', $customerSupplier->mobile_no) }}" type="text" name="mobile_no" class="form-control" id="form-text2" placeholder="enter mobile number">
                                @error('mobile_no')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    

                    <!-- Address Field -->
                    <div class="mb-3">
                        <label for="form-text3" class="form-label fs-14 text-dark">Address <sup class="text-danger fs-6">*</sup></label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-map-pin-line"></i></div>
                            <input value="{{ old('address', $customerSupplier->address) }}" type="text" name="address" class="form-control" id="form-text3" placeholder="enter address">
                            @error('address')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Customer/Supplier Field -->
                    <div class="mb-3">
                        <label for="customer_supplier" class="form-label fs-14 text-dark">Customer/Supplier<sup class="text-danger fs-6">*</sup></label>
                        <div class="input-group">
                            <select name="customer_supplier" class="form-control" id="customer_supplier" required>
                                <option value="">Select</option>
                                <option value="Only Supplier" {{ old('customer_supplier', $customerSupplier->customer_supplier) == 'Only Supplier' ? 'selected' : '' }}>Only Supplier</option>
                                <option value="Only Customer" {{ old('customer_supplier', $customerSupplier->customer_supplier) == 'Only Customer' ? 'selected' : '' }}>Only Customer</option>
                                <option value="Both Supplier & Customer" {{ old('customer_supplier', $customerSupplier->customer_supplier) == 'Both Supplier & Customer' ? 'selected' : '' }}>Both Supplier & Customer</option>
                            </select>
                            @error('customer_supplier')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <!-- GST No Field -->
                        <div class="mb-3 col-md-6 p-2">
                            <label for="form-text4" class="form-label fs-14 text-dark">GST No</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="ri-hashtag"></i></div>
                                <input value="{{ old('gst_no', $customerSupplier->gst_no) }}" type="text" name="gst_no" class="form-control" id="form-text4" placeholder="enter GSt number">
                                @error('gst_no')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- PAN No Field -->
                        <div class="mb-3 col-md-6 p-2">
                            <label for="form-text5" class="form-label fs-14 text-dark">PAN No</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="ri-id-card-line"></i></div>
                                <input value="{{ old('pan_no', $customerSupplier->pan_no) }}" type="text" name="pan_no" class="form-control" id="form-text5" placeholder="enter PAN number">
                                @error('pan_no')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="country"  class="form-label fs-14 text-dark">Country *</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-flag-line"></i></div>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" placeholder="enter country" value="{{ old('country', $customerSupplier->country) }}" required>
                            @error('country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>  
                    </div>
                    <div class="mb-3">
                        <label for="state"  class="form-label fs-14 text-dark">State *</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-pin-distance-line"></i></div>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" placeholder="enter state" value="{{ old('state', $customerSupplier->state) }}" required>
                        @error('state')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        
                    </div>
                    <div class="mb-3">
                        <label for="city"  class="form-label fs-14 text-dark">City *</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-building-line"></i></div>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" placeholder="enter city" value="{{ old('city', $customerSupplier->city) }}" required>
                        @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        
                    </div>
                    <button type="submit" class="btn btn-secondary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
    
@endsection
