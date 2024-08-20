@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Create Stock Aging</h2>
            <a href="{{route('stock-aging.index')}}" type="button" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('stock-aging.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Stock Aging</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Stock Aging</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="container">
            <div class="col-12 mb-5 mt-3 bg-white p-5 shadow"> 
                <form action="{{ route('age_categories.store') }}" method="POST">
                    @csrf
                    <label for="title">Title:</label>
                    <input type="text" name="title" required>

                    <label for="days">Days:</label>
                    <input type="text" name="days" required>

                    <button type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
