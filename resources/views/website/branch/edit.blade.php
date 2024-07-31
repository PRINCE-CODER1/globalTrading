@extends('website.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mt-5 mb-3">
                <h2 class="mb-0">Edit Branch</h2>
                <a href="{{route('branches.index')}}" type="button" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 my-5 bg-white p-5 shadow">
                <form action="{{ route('branches.update', $branch->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="form-text1" class="form-label fs-14 text-dark">Branch Name</label>
                        <div class="input-group">
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend"><i class="ri-user-line"></i></span>
                                <input value="{{ old('name', $branch->name) }}"  name="name" type="text" class="form-control" placeholder="branch name" id="validationCustomUsername"
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
                        <label class="form-label fs-14 text-dark" for="user_id">User Name:</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    </div>
                    <div class="mb-3">
                        <label for="form-text1" class="form-label fs-14 text-dark">Mobile</label>
                        <div class="input-group">
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend"><i class="ri-phone-line"></i></span>
                                <input value="{{ old('mobile', $branch->mobile) }}"  name="mobile" type="text" class="form-control" placeholder="enter mobile" id="validationCustomUsername"
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
                        <label for="form-text1" class="form-label fs-14 text-dark">Address</label>
                        <div class="input-group">
                            <div class="input-group has-validation">
                                <textarea name="address" class="form-control" required>{{ old('address', $branch->address) }}</textarea>
                            </div>
                            @error('address')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection