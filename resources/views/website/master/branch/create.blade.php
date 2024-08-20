@extends('website.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 ">
            <h4 class="mb-0">
                Create Branch
            </h4>
            <a href="{{route('branches.index')}}" type="button" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('branches.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Branch</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Branch</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="container">
            <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
                <form action="{{ route('branches.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="form-text1" class="form-label fs-14 text-dark">Branch Name</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-user-line"></i></div>
                            <input value="{{old('name')}}" type="text" name="name" class="form-control" id="form-text1" placeholder="">
                            @error('name')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        {{-- <label class="form-label fs-14 text-dark" for="user_id">User Name:</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly> --}}
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="form-text1" class="form-label fs-14 text-dark">Mobile</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-phone-line"></i></div>
                            <input value="{{old('mobile')}}" type="text" name="mobile" class="form-control" id="form-text1" placeholder="">
                            @error('mobile')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="form-text1" class="form-label fs-14 text-dark">Address</label>
                        <div class="input-group">
                            <textarea name="address" class="form-control" id="" cols="10" required placeholder="address eg-H.no."></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
    
</div>
@endsection