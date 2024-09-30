@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-2">
            <h2 class="mb-0 d-flex justify-content-between align-items-center">Create External Challan</h2>
            <a href="{{ route('external.index') }}" class="btn btn-outline-secondary">
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
                    <li class="breadcrumb-item"><a href="{{ route('external.index') }}"><i class="ti ti-apps me-1 fs-15"></i>External  Chalaan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create External Chalaan</li>
                </ol>
            </nav>
        </div>
    </div>   
    <hr>
</div>
<div class="container mb-5">
    <div class="bg-white p-4 shadow-sm rounded">
        @livewire('crm.external-chalaan-create')
    </div>
</div>
@endsection
