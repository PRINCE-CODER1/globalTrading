<!-- resources/views/lead_sources/edit.blade.php -->

@extends('website.master')

@section('content')
<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
            <h4>Create Lead Source</h4>
            <a href="{{route('leads.index')}}" class="btn btn-secondary btn-wave float-end">Back</a>
            </div>
        </div>
    </div>
    <div class="container">
        
    
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
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
    
            <div class="mb-3 form-check">
                <input type="checkbox" id="active" name="active" value="1" {{ old('active', $leadSource->active ?? false) ? 'checked' : '' }}>
                <input type="hidden" name="active" value="0">
                <label class="form-check-label" for="active">Active</label>
            </div>
    
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
