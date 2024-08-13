@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Create Series</h2>
            <a href="{{route('series.index')}}" type="button" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('series.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Series</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Series</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="container">
            <div class="col-12 mb-5 mt-3 bg-white p-5 shadow"> 
                <form action="{{ route('series.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fs-14 text-dark">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <div class="mb-3">
                        <label for="description" class="form-label fs-14 text-dark">Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <div class="mb-3">
                        <label for="discount_rate" class="form-label fs-14 text-dark">Discount Rate (%)</label>
                        <input type="number" name="discount_rate" id="discount_rate" class="form-control" step="0.01" min="0" max="100">
                        @error('discount_rate')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <div class="mb-3">
                        <label for="dismantling_required" class="form-label fs-14 text-dark me-3">Dismantling</label>
                        <label class="switch">
                            <input type="checkbox" name="dismantling_required" id="dismantling_required" value="1">
                            <span class="slider round"></span>
                        </label>
                        @error('dismantling_required')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <div class="mb-3">
                        <label for="tax_rate" class="form-label fs-14 text-dark">Tax Rate (%)</label>
                        <input type="number" name="tax_rate" id="tax_rate" class="form-control" step="0.01" min="0" max="100">
                        @error('tax_rate')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <button type="submit" class="btn btn-secondary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

  
@endsection
