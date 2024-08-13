@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Edit Visits</h2>
            <a href="{{route('visits.index')}}" type="button" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('visits.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Visits</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Visits</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="container">
            <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
                <form action="{{ route('visits.update', $visit->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="product_id" class="form-label fs-14 text-dark">Product</label>
                        <select name="product_id" id="product_id" class="form-control" required>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ $visit->product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->product_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="visit_date" class="form-label fs-14 text-dark">Visit Date</label>
                        <input type="date" name="visit_date" id="visit_date" class="form-control" value="{{ $visit->visit_date->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label fs-14 text-dark">Location</label>
                        <input type="text" name="location" id="location" class="form-control" value="{{ $visit->location }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="purpose" class="form-label fs-14 text-dark">Purpose</label>
                        <input type="text" name="purpose" id="purpose" class="form-control" value="{{ $visit->purpose }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label fs-14 text-dark">Notes</label>
                        <textarea name="notes" id="notes" class="form-control">{{ $visit->notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary">Update Visit</button>
                </form> 
            </div>
        </div>
    </div>
</div>

@endsection