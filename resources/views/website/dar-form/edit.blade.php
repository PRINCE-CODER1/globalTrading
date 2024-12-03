@extends('website.master')

@section('title', 'Daily Activity Reports')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-2">
            <h2 class="mb-0 d-flex justify-content-between align-items-center">Edit daily-report</h2>
            <a href="{{ route('daily-report.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-chevron-left me-1"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('daily-report.index') }}"><i class="ti ti-apps me-1 fs-15"></i>daily-report</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit daily-report</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container my-3">
    <div class="bg-white p-4 shadow-sm rounded">
        <form action="{{ route('daily-report.update', $dar->dar_id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Use PUT method for updating -->
            
            <div class="mb-3">
                <label for="customer_id" class="form-label fs-14 text-dark" >Customer</label>
                <select name="customer_id" id="customer_id" class="form-control" disabled>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" 
                            {{ $dar->customer_id == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="pov_id" class="form-label fs-14 text-dark">Purpose of Visit</label>
                <select name="pov_id" id="pov_id" class="form-control" disabled>
                    @foreach($purposes as $purpose)
                        <option value="{{ $purpose->id }}" 
                            {{ $dar->pov_id == $purpose->id ? 'selected' : '' }}>
                            {{ $purpose->visitor_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="remarks" class="form-label fs-14 text-dark">Remarks</label>
                <textarea name="remarks" id="remarks" class="form-control">{{ $dar->remarks }}</textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label fs-14 text-dark">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="0" {{ $dar->status == 0 ? 'selected' : '' }}>Close</option>
                    <option value="1" {{ $dar->status == 1 ? 'selected' : '' }}>Open</option>
                </select>
            </div>

            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">


            

            <button type="submit" class="btn btn-secondary"><i class="ri-save-3-line"></i> Update</button>
        </form>
    </div>
</div>
@endsection