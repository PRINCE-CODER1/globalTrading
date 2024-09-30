@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-2">
            <h4 class="mb-0">Create Team</h4>
            <a href="{{ route('teams.index') }}" class="btn btn-secondary btn-wave float-end">
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
                        <a href="{{ route('teams.index') }}"><i class="bi bi-clipboard me-1 fs-15"></i> Team</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create Team</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('teams.store') }}" method="POST">
                @csrf

                <!-- Team Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="ri-team-line"></i> Team Name <sup class="text-danger">*</sup>
                    </label>                    
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-team-line"></i></span>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-secondary"><i class="ri-save-3-line"></i> Create Team</button>
            </form>
        </div>
    </div>
</div>

@endsection
