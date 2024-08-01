@extends('website.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mt-5">
                <h4 class="mb-0">
                    Edit Stock Category
                </h4>
                <a href="{{route('stocks-categories.index')}}" type="button" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('stocks-categories.index')}}"><i class="ti ti-apps me-1 fs-15"></i>stocks-categories</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit stocks-categories</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="container">
                <div class="col-12 mt-3 mb-5 bg-white p-5 shadow">
                    <form action="{{ route('stocks-categories.update', $stockCategory->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                
                       
                        <div class="mb-3">
                            <label for="form-text1" class="form-label fs-14 text-dark">Category Name</label>
                            <div class="input-group">
                                <div class="input-group has-validation">
                                    <span class="input-group-text" id="inputGroupPrepend"><i class="ri-menu-search-line"></i></span>
                                    <input value="{{ old('name', $stockCategory->name) }}"  name="name" type="text" class="form-control" placeholder="enter category" id="validationCustomUsername"
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
                            <label for="parent_id" class="form-label fs-14 text-dark">Parent Category</label>
                            <select id="parent_id" name="parent_id" class="form-control">
                                <option value="">None</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $stockCategory->parent_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
    
                        </div>
                        
                        <div class="mb-3">
                            <label for="form-text1" class="form-label fs-14 text-dark">Category Description</label>
                            
                                    <textarea id="description" name="description" class="form-control" >{{ old('description', $stockCategory->description) }}</textarea>
    
                        </div>
                
                        <button type="submit" class="btn btn-secondary">Update Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
