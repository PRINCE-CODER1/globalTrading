@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
        <h4>Create Stock Category</h4>
        <a href="{{route('stocks-categories.index')}}" class="btn btn-outline-secondary btn-wave float-end">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-6 mt-5 bg-white p-5 shadow">
            <form action="{{ route('stocks-categories.store') }}" method="POST">
                @csrf
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
