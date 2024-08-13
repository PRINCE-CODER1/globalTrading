@extends('website.master')
@section('title', 'Purchase Order List')
@section('content')
{{-- <div class="container">
    <h1>Purchase Orders</h1>

    <a href="{{ route('purchase_orders.create') }}" class="btn btn-primary mb-3">Create Purchase Order</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Purchase Order No</th>
                <th>Date</th>
                <th>Supplier</th>
                <th>Agent/User</th>
                <th>Segment</th>
                <th>Order Branch</th>
                <th>Delivery Branch</th>
                <th>Customer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseOrders as $order)
                <tr>
                    <td>{{ $order->purchase_order_no }}</td>
                    <td>{{ $order->date }}</td>
                    <td>{{ $order->supplier->name ?? 'N/A' }}</td>
                    <td>{{ $order->agent->name }}</td>
                    <td>{{ $order->segment->name }}</td>
                    <td>{{ $order->orderBranch->name }}</td>
                    <td>{{ $order->deliveryBranch->name }}</td>
                    <td>{{ $order->customer->name ?? 'N/A' }}</td>
                    <td>
                        <!-- Add any actions like Edit, Delete here -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $purchaseOrders->links('custom-pagination-links') }}
</div> --}}
<div>
    @livewire('inv-management.purchase-order')
</div>
@endsection
