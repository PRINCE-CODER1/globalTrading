@extends('website.master')
@section('title', 'Create Challan')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Create Challan</h2>
            <a href="{{route('challan-types.index')}}" type="button" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('challan-types.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Challan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Challan</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="container">
            <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">      
                <form action="{{ route('challan-types.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="form-text1" class="form-label fs-14 text-dark">Name</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-user-line"></i></div>
                            <input type="text" name="name" class="form-control" id="name" placeholder="enter name" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fs-14 text-dark">Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="enter description"></textarea>
                    </div>

                    <button type="submit" class="btn btn-secondary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection