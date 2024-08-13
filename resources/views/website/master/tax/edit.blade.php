@extends('website.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Edit Tax</h2>
            <a href="{{route('taxes.index')}}" type="button" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('taxes.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Taxes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Taxes</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="container">
            <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
                <form action="{{ route('taxes.update', $tax->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="form-text1" class="form-label fs-14 text-dark">Name</label>
                        <div class="input-group">
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend"><i class="ri-user-line"></i></span>
                                <input value="{{ old('name', $tax->name) }}"  name="name" type="text" class="form-control" placeholder="enter formula" id="validationCustomUsername"
                                    aria-describedby="inputGroupPrepend" required>
                                <div class="invalid-feedback">
                                    Please fill the title.
                                </div>
                            </div>
                            @error('name')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="form-text1" class="form-label fs-14 text-dark">Value</label>
                        <div class="input-group">
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend"><i class="ri-hand-coin-line"></i></span>
                                <input value="{{ old('value', $tax->value) }}"  name="value" type="number" class="form-control" step="0.01" placeholder="enter value" id="validationCustomUsername"
                                    aria-describedby="inputGroupPrepend" required>
                                <div class="invalid-feedback">
                                    Please fill the title.
                                </div>
                            </div>
                            @error('value')
                                <p class="text-danger">{{$message}}</p>
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