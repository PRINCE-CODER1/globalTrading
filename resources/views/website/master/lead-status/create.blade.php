@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between ">
        <h4 class="mb-0">Create Lead Status</h4>
        <a href="{{route('leads-status.index')}}" class="btn btn-secondary btn-wave float-end">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('leads-status.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Lead Status</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Lead Status</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="container">
            <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
                <form action="{{ route('leads-status.store') }}" method="POST">
                    @csrf
            
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <input type="text" class="form-control" id="status" name="status" value="{{ old('status') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="details" class="form-label">Details</label>
                        <textarea class="form-control" id="details" name="details">{{ old('details') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary">Create Lead Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
    
@endsection
