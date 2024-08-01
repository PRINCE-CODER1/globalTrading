@extends('website.master')

@section('content')
<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between ">
                <h4>Edit Workshop</h4>
                <a href="{{ route('workshops.index') }}" class="btn btn-outline-secondary btn-wave float-end">Back</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('workshops.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Workshop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Workshop</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 mt-3 mb-5 bg-white p-5 shadow">
                <form action="{{ route('workshops.update', $workshop->id) }}" method="POST">
                    @csrf
                    @method('PUT')
        
                    <div class="mb-3">
                        <label for="form-text1" class="form-label fs-14 text-dark">Workshop Name</label>
                        <div class="input-group">
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend"><i class="ri-phone-line"></i></span>
                                <input value="{{ old('name', $workshop->name) }}"  name="name" type="text" class="form-control" placeholder="enter mobile" id="validationCustomUsername"
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
                        <label for="form-text1" class="form-label fs-14 text-dark">Branch</label>
                        <div class="input-group">
                            <select class="form-control mb-3" id="branch_id" name="branch_id" required>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id', $workshop->branch_id) == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary">Update</button>
                </form>
            </div>
        </div>
    </div>
        
        
    </div>
</div>
@endsection
