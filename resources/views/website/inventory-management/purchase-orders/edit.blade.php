@extends('website.master')

@section('title', 'Edit Purchase Order')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Edit Purchase Order</h2>
            <a href="{{route('purchase_orders.index')}}" type="button" class="btn btn-outline-secondary">Back</a>
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

<div class="container mt-5">

    <div class="bg-white p-4 shadow-sm rounded">
        <form method="POST" action="{{ route('purchase_orders.update', $purchaseOrder->id) }}">
            @csrf
            @method('PUT')

            <div class="row mb-4">
                <!-- Purchase Order No -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="purchase_order_no" class="form-label">Purchase Order No</label>
                        <input type="text" class="form-control" id="purchase_order_no" name="purchase_order_no" value="{{ $purchaseOrder->purchase_order_no }}" readonly>
                    </div>
                </div>

                <!-- Date Field -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ $purchaseOrder->date }}" required>
                    </div>
                </div>

                <!-- Supplier Field -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <select class="form-select" id="supplier_id" name="supplier_id" required>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ $purchaseOrder->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Supplier Sale Order No -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="supplier_sale_order_no" class="form-label">Supplier Sale Order No</label>
                        <input type="text" class="form-control" id="supplier_sale_order_no" name="supplier_sale_order_no" value="{{ $purchaseOrder->supplier_sale_order_no }}">
                    </div>
                </div>

                <!-- Agent Field -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="agent_id" class="form-label">Agent</label>
                        <select class="form-select" id="agent_id" name="agent_id" required>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ $purchaseOrder->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Segment Field -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="segment_id" class="form-label">Segment</label>
                        <select class="form-select" id="segment_id" name="segment_id" required>
                            @foreach($segments as $segment)
                                <option value="{{ $segment->id }}" {{ $purchaseOrder->segment_id == $segment->id ? 'selected' : '' }}>{{ $segment->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Order Branch Field -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="order_branch_id" class="form-label">Order Branch</label>
                        <select class="form-select" id="order_branch_id" name="order_branch_id" required>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ $purchaseOrder->order_branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Delivery Branch Field -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="delivery_branch_id" class="form-label">Delivery Branch</label>
                        <select class="form-select" id="delivery_branch_id" name="delivery_branch_id" required>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ $purchaseOrder->delivery_branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Customer Field -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select class="form-select" id="customer_id" name="customer_id">
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ $purchaseOrder->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Customer Sale Order No -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="customer_sale_order_no" class="form-label">Customer Sale Order No</label>
                        <input type="text" class="form-control" id="customer_sale_order_no" name="customer_sale_order_no" value="{{ $purchaseOrder->customer_sale_order_no }}">
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Customer Sale Order Date -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="customer_sale_order_date" class="form-label">Customer Sale Order Date</label>
                        <input type="date" class="form-control" id="customer_sale_order_date" name="customer_sale_order_date" value="{{ $purchaseOrder->customer_sale_order_date }}">
                    </div>
                </div>
            </div>

            <!-- Items Container -->
            <div id="items-container">
                @foreach($purchaseOrder->items as $index => $item)
                    <div class="item-row mb-3 p-3 border rounded">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="items[{{ $index }}][product_id]" class="form-label">Product</label>
                                <select class="form-select" name="items[{{ $index }}][product_id]" required>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="items[{{ $index }}][quantity]" class="form-label">Quantity</label>
                                <input type="number" class="form-control item-quantity" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="items[{{ $index }}][price]" class="form-label">Price</label>
                                <input type="number" step="0.01" class="form-control item-price" name="items[{{ $index }}][price]" value="{{ $item->price }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="items[{{ $index }}][discount]" class="form-label">Discount (%)</label>
                                <input type="number" step="0.01" class="form-control item-discount" name="items[{{ $index }}][discount]" value="{{ $item->discount }}" min="0" max="100">
                            </div>

                            <div class="col-md-6">
                                <button type="button" class="btn btn-dark-outline fs-2 remove-item mt-3">Remove<i class="ms-3 ri-close-circle-fill"></i></button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Add New Item Button -->
            <button type="button" id="add-item" class="btn btn-primary-outline mb-3 fs-2 text-danger" id="add-item">Add Product<i class="ms-3 ri-add-circle-fill"></i></button>

            <!-- Subtotal Field -->
            <div class="mb-3">
                <label for="subtotal" class="form-label">Subtotal</label>
                <input type="text" class="form-control" id="subtotal" name="subtotal" value="0.00" readonly>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-secondary">Update Purchase Order</button>
        </form>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    let itemCount = document.querySelectorAll('.item-row').length;

    // Function to calculate subtotal
    function calculateSubtotal() {
        let subtotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
            const price = parseFloat(row.querySelector('.item-price').value) || 0;
            const discount = parseFloat(row.querySelector('.item-discount').value) || 0;
            subtotal += (quantity * price) * (1 - discount / 100);
        });
        document.getElementById('subtotal').value = subtotal.toFixed(2);
    }

    // Add New Item Event
    document.getElementById('add-item').addEventListener('click', function () {
        const itemsContainer = document.getElementById('items-container');
        const newItemRow = document.createElement('div');
        newItemRow.classList.add('item-row', 'mb-3', 'p-3', 'border', 'rounded');
        newItemRow.innerHTML = `
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="items[${itemCount}][product_id]" class="form-label">Product</label>
                    <select class="form-select" name="items[${itemCount}][product_id]" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="items[${itemCount}][quantity]" class="form-label">Quantity</label>
                    <input type="number" class="form-control item-quantity" name="items[${itemCount}][quantity]" required>
                </div>

                <div class="col-md-4">
                    <label for="items[${itemCount}][price]" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control item-price" name="items[${itemCount}][price]" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="items[${itemCount}][discount]" class="form-label">Discount (%)</label>
                    <input type="number" step="0.01" class="form-control item-discount" name="items[${itemCount}][discount]" min="0" max="100">
                </div>

                <div class="col-md-6">
                    <button type="button" class="btn btn-dark-outline fs-2 remove-item mt-3">Remove<i class="ms-3 ri-close-circle-fill"></i></button>
                </div>
            </div>
        `;
        itemsContainer.appendChild(newItemRow);
        itemCount++;
    });

    // Remove Item Event
    document.getElementById('items-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.item-row').remove();
            calculateSubtotal();
        }
    });

    // Update subtotal on change in item fields
    document.getElementById('items-container').addEventListener('input', function () {
        calculateSubtotal();
    });

    // Initialize subtotal
    calculateSubtotal();
});

    </script>
@endpush

@endsection