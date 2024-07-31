<!-- resources/views/lead_sources/edit.blade.php -->

@extends('website.master')

@section('content')
<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
            <h4 class="mb-0">Create Lead Source</h4>
            <a href="{{route('leads.index')}}" class="btn btn-secondary btn-wave float-end">Back</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 my-5 bg-white p-5 shadow">
                <form action="{{ route('leads.update', $leadSource->id  ) }}" method="POST">
                    @csrf
                    @method('PUT')
            
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $leadSource->name) }}" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description">{{ old('description', $leadSource->description) }}</textarea>
                    </div>
            
                    <div class="mb-3">
                        <label class="form-label me-3" for="active">Active</label>
                        <input type="hidden" name="active" value="0">
                        <label class="switch">
                            <input type="checkbox" id="active" name="active" value="1" 
                                {{ old('active', $leadSource->active ?? false) ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    
            
                    <button type="submit" class="btn btn-secondary">Update</button>
                </form>
            </div>
        </div>
    </div>
    
        
    </div>
</div>
@endsection
