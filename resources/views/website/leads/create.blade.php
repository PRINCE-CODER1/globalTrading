@extends('website.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
            <h4>Create Lead Source</h4>
            <a href="{{route('leads.index')}}" class="btn btn-outline-secondary btn-wave float-end">Back</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 my-5 bg-white p-5 shadow">
                <form action="{{ route('leads.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="form-text1" class="form-label fs-14 text-dark">Enter name</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-user-line"></i></div>
                            <input value="{{old('name')}}" type="text" name="name" class="form-control" id="form-text1" placeholder="enter lead">
                            @error('name')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="description">{{ old('description') }}</textarea>     
                    </div>
            
                    <div class="mb-3">
                        
                    </div>
            
                    <div class="mb-3 ">
                        <label class="form-label me-3" for="active">Active</label>
                        <input type="hidden" name="active" value="0">
                        <label class="switch">
                            <input type="checkbox" id="active" name="active" value="1" {{ old('active', $leadSource->active ?? false) ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>
            
                    <button type="submit" class="btn btn-secondary">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection
