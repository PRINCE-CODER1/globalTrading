@extends('website.master')
@section('title', 'Create Purchase Order')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Create Purchase Order</h2>
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
                    <li class="breadcrumb-item"><a href="{{route('purchase_orders.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Purchase</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Purchase Order</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container my-5">

    <div class="bg-white p-4 shadow-sm rounded">
        <form method="POST" action="{{ route('purchase_orders.store') }}">
            @csrf

            <div class="row mb-4">
                <!-- Purchase Order No -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="purchase_order_no" class="form-label fs-14 text-dark">Purchase Order No</label>
                        <input type="text" class="form-control" id="purchase_order_no" name="purchase_order_no" value="{{ $purchaseOrderNo }}" readonly>
                    </div>
                </div>

                <!-- Date Field -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="date" class="form-label fs-14 text-dark">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
                    </div>
                </div>

                <!-- Supplier Field -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label fs-14 text-dark">Supplier</label>
                        <select class="form-select" id="supplier_id" name="supplier_id" required>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Supplier Sale Order No -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="supplier_sale_order_no" class="form-label fs-14 text-dark">Supplier Sale Order No</label>
                        <input type="text" class="form-control" id="supplier_sale_order_no" name="supplier_sale_order_no" value="{{ old('supplier_sale_order_no') }}">
                    </div>
                </div>

                <!-- Agent Field -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="agent_id" class="form-label fs-14 text-dark">Agent</label>
                        <select class="form-select" id="agent_id" name="agent_id" required>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Segment Field -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="segment_id" class="form-label fs-14 text-dark">Segment</label>
                        <select class="form-select" id="segment_id" name="segment_id" required>
                            @foreach($segments as $segment)
                                <option value="{{ $segment->id }}" {{ old('segment_id') == $segment->id ? 'selected' : '' }}>{{ $segment->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Order Branch Field -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="order_branch_id" class="form-label fs-14 text-dark">Order Branch</label>
                        <select class="form-select" id="order_branch_id" name="order_branch_id" required>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('order_branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Delivery Branch Field -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="delivery_branch_id" class="form-label fs-14 text-dark">Delivery Branch</label>
                        <select class="form-select" id="delivery_branch_id" name="delivery_branch_id" required>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('delivery_branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Customer Field -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="customer_id" class="form-label fs-14 text-dark">Customer</label>
                        <select class="form-select" id="customer_id" name="customer_id">
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Customer Sale Order No -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="customer_sale_order_no" class="form-label fs-14 text-dark">Customer Sale Order No</label>
                        <input type="text" class="form-control" id="customer_sale_order_no" name="customer_sale_order_no" value="{{ old('customer_sale_order_no') }}">
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Customer Sale Order Date -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="customer_sale_order_date" class="form-label fs-14 text-dark">Customer Sale Order Date</label>
                        <input type="date" class="form-control" id="customer_sale_order_date" name="customer_sale_order_date" value="{{ old('customer_sale_order_date') }}">
                    </div>
                </div>
            </div>

            <!-- Items Container -->
            <div id="items-container">
                <div class="item-row mb-3 p-3 border rounded">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="items[0][product_id]" class="form-label fs-14 text-dark">Product</label>
                            <select class="form-select" name="items[0][product_id]" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="items[0][quantity]" class="form-label fs-14 text-dark">Quantity</label>
                            <input type="number" class="form-control item-quantity" name="items[0][quantity]" value="{{ old('items[0][quantity]') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="items[0][price]" class="form-label fs-14 text-dark">Price</label>
                            <input type="number" step="0.01" class="form-control item-price" name="items[0][price]" value="{{ old('items[0][price]') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="items[0][discount]" class="form-label fs-14 text-dark">Discount (%)</label>
                            <input type="number" step="0.01" class="form-control item-discount" name="items[0][discount]" value="{{ old('items[0][discount]') }}" min="0" max="100">
                        </div>

                        <div class="col-md-6">
                            <button type="button" class="btn btn-dark-outline fs-2 remove-item mt-3">Remove<i class="ms-3 ri-close-circle-fill"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button to Add More Items -->
            <button type="button" class="btn btn-primary-outline mb-3 fs-2 text-danger" id="add-item">Add Product<i class="ms-3 ri-add-circle-fill"></i></button>

            <!-- Subtotal Field -->
            <div class="mb-3">
                <label for="subtotal" class="form-label fs-14 text-dark">Subtotal</label>
                <input type="text" class="form-control" id="subtotal" name="subtotal" value="0.00" readonly>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-secondary">Save Purchase Order</button>
        </form>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let itemCount = 1;

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
                            <label for="items[${itemCount}][product_id]" class="form-label fs-14 text-dark">Product</label>
                            <select class="form-select" name="items[${itemCount}][product_id]" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="items[${itemCount}][quantity]" class="form-label fs-14 text-dark">Quantity</label>
                            <input type="number" class="form-control item-quantity" name="items[${itemCount}][quantity]" value="{{ old('items[${itemCount}][quantity]') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="items[${itemCount}][price]" class="form-label fs-14 text-dark">Price</label>
                            <input type="number" step="0.01" class="form-control item-price" name="items[${itemCount}][price]" value="{{ old('items[${itemCount}][price]') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="items[${itemCount}][discount]" class="form-label fs-14 text-dark">Discount (%)</label>
                            <input type="number" step="0.01" class="form-control item-discount" name="items[${itemCount}][discount]" value="{{ old('items[${itemCount}][discount]') }}" min="0" max="100">
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
