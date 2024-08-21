@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Edit Stock Aging</h2>
            <a href="{{ route('age_categories.index') }}" type="button" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('age_categories.index') }}"><i class="ti ti-apps me-1 fs-15"></i>Stock Aging</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Stock Aging Master</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="container">
            <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
                <form action="{{ route('age_categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label fs-14 text-dark">Title :</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $category->title) }}" required>
                    </div>
                    {{-- <label for="title">Title:</label>
                    <input type="text" name="title" value="{{ old('title', $category->title) }}" required> --}}
                    <div class="mb-3">
                        <label for="days" class="form-label fs-14 text-dark">Days :</label>
                        <input type="text" name="days" id="days" class="form-control" value="{{ old('days', $category->days) }}" required>
                    </div>
                    {{-- <label for="days">Days:</label>
                    <input type="text" name="days" value="{{ old('days', $category->days) }}" required> --}}

                    <button type="submit" class="btn btn-secondary mt-3">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
