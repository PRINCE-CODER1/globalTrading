@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Edit Visit</h2>
            <a href="{{ route('visits.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"><i class="bi bi-house-door me-1 fs-15"></i> Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('visits.index') }}"><i class="bi bi-calendar-check me-1 fs-15"></i> Visits</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Visit</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('visits.update', $visit->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Visitor Name Field -->
                <div class="mb-3">
                    <label for="visitor_name" class="form-label fs-14 text-dark">
                        <i class="bi bi-person me-1"></i> Visitor Name <sup class="text-danger">*</sup>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="visitor_name" id="visitor_name" class="form-control" value="{{ old('visitor_name', $visit->visitor_name) }}" required>
                    </div>
                </div>

                <!-- Hidden Created By Field -->
                <div class="mb-3">
                    <input type="hidden" name="created_by" id="created_by" class="form-control" value="{{ $visit->created_by }}" readonly>
                </div>

                <button type="submit" class="btn btn-secondary mt-3">
                    <i class="bi bi-pencil-square me-1"></i> Update
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
