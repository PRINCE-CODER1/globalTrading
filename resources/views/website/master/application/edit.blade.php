@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Edit application</h2>
            <a href="{{ route('application.index') }}" class="btn btn-outline-secondary">
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
                        <a href="javascript:void(0);"><i class="bi bi-house-door me-1 fs-15"></i>Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('application.index') }}"><i class="bi bi-geo-alt me-1 fs-15"></i>application</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit application</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('application.update', $application->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- application Name Field -->
                <div class="mb-3">
                    <label for="application_name" class="form-label fs-14 text-dark">
                        <i class="bi bi-building me-1"></i> Branch Name
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                        <input value="{{ old('name', $application->name) }}" type="text" name="name" class="form-control" id="application_name" placeholder="Enter application name" required>
                    </div>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User ID Field (Hidden) -->
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-save me-1"></i> Update
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
