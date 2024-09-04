@extends('website.master')
@section('title', 'Edit Purchase Order')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-2">
            <h2 class="mb-0 d-flex justify-content-between align-items-center">Edit Purchase</h2>
            <a href="{{ route('purchase.index') }}" class="btn btn-outline-secondary">
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
                    <li class="breadcrumb-item"><a href="{{ route('purchase.index') }}"><i class="ti ti-apps me-1 fs-15"></i>Purchase Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Purchase</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="bg-white p-4 shadow-sm rounded">
        @livewire('inv-management.purchase-edit', ['purchaseId' => $purchaseId])
    </div>
</div>

@endsection
