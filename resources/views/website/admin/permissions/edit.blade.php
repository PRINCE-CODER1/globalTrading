@extends('website.master')

@section('title', 'Edit Permission')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-3">
            <h4 class="mb-0">
                Edit permission
            </h4>
            <a href="{{route('permissions.index')}}" type="button" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
       <div class="container">
        <div class="col-12 my-5 bg-white p-5 shadow">
            <form method="POST" action="{{ route('permissions.update', $permissions->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Permission Name</label>
                    <div class="input-group">
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="ri-menu-search-line"></i></span>
                            <input value="{{ old('name', $permissions->name) }}"  name="name" type="text" class="form-control" placeholder="enter category" id="validationCustomUsername"
                                aria-describedby="inputGroupPrepend" >
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
                    <label class="form-label" for="category">Category</label>
                    <select name="category" id="category" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ (old('category', $permissions->category) == $category) ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-secondary">Update</button>
                
            </form>
        </div>
       </div>
    </div>
</div>
@endsection
