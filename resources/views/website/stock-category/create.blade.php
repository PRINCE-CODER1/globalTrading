@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between ">
        <h4 class="mb-0">Create Stock Category</h4>
        <a href="{{route('stocks-categories.index')}}" class="btn btn-outline-secondary btn-wave float-end">Back</a>
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
                    <li class="breadcrumb-item active" aria-current="page">Create stocks-categories</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('stocks-categories.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Category Name</label>
                    <div class="input-group">
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="ri-menu-search-line"></i></span>
                            <input  name="name" type="text" class="form-control" placeholder="category name" id="validationCustomUsername"
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
                    <label for="form-text1" class="form-label fs-14 text-dark">Parent Category</label>
                    <div class="input-group">
                        <div class="input-group has-validation">
                            <select id="parent_id" name="parent_id" class="form-control">
                                <option value="">None</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Category Description</label>
                    <div class="input-group">
                        <div class="input-group has-validation">
                            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                            <div class="invalid-feedback">
                                Please fill the description.
                            </div>
                        </div>
                        @error('description')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-secondary">Create Category</button>
            </form>
        </div>
    </div>
    
   
</div>
@endsection
