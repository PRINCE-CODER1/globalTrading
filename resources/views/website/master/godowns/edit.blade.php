@extends('website.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mt-5">
                <h2 class="mb-0">Edit Godowns</h2>
                <a href="{{route('godowns.index')}}" type="button" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('godowns.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Godowns</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Godowns</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="container">
                <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
                    <form action="{{ route('godowns.update', $godown->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <div class="mb-3">
                                <label for="form-text1" class="form-label fs-14 text-dark">Godown Name</label>
                                <div class="input-group">
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="ri-user-line"></i></span>
                                        <input value="{{ old('godown_name', $godown->godown_name) }}"  name="godown_name" type="text" class="form-control" placeholder="godown name" id="validationCustomUsername"
                                            aria-describedby="inputGroupPrepend" required>
                                        <div class="invalid-feedback">
                                            Please fill the title.
                                        </div>
                                    </div>
                                    @error('godown_name')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fs-14 text-dark" for="user_id">User Name:</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            </div>
                            <div class="mb-3">
                                <label for="branch_id">Branch</label>
                                <select class="form-control" id="branch_id" name="branch_id" required>
                                    @foreach($branches as $branch)
                                        <option  value="{{ $branch->id }}" {{ $branch->id == old('branch_id', $godown->branch_id) ? 'selected' : '' }}>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="form-text1" class="form-label fs-14 text-dark">Mobile</label>
                                <div class="input-group">
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="ri-user-line"></i></span>
                                        <input value="{{ old('mobile', $godown->mobile) }}"  name="mobile" type="text" class="form-control" placeholder="enter mobile" id="validationCustomUsername"
                                            aria-describedby="inputGroupPrepend" required>
                                        <div class="invalid-feedback">
                                            Please fill the title.
                                        </div>
                                    </div>
                                    @error('mobile')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" required>{{ old('address', $godown->address) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-secondary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection