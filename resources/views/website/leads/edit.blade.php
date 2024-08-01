<!-- resources/views/lead_sources/edit.blade.php -->

@extends('website.master')

@section('content')
<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between ">
            <h4 class="mb-0">Edit Lead Source</h4>
            <a href="{{route('leads.index')}}" class="btn btn-secondary btn-wave float-end">Back</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('leads.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Leads</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Lead</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
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
