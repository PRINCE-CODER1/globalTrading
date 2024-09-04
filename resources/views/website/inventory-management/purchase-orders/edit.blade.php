@extends('website.master')

@section('title', 'Edit Purchase Order')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Edit Purchase Order</h2>
            <a href="{{route('purchase_orders.index')}}" type="button" class="btn btn-outline-secondary"><i class="bi bi-chevron-left me-1"></i>Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('purchase_orders.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Purchase Order</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Purchase Order</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div>
    @livewire('inv-management.edit-purchase-order', ['purchaseOrder' => $purchaseOrder])
</div>

@endsection