@extends('website.master')

@section('title', 'Create Sale Order')

@section('content')
<div class="container my-5">
    <!-- Header Section -->
    <div class="row mb-2">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Create Sale Order</h2>
            <a href="{{ route('sale_orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-chevron-left me-1"></i>  Back
            </a>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">
                            <i class="fas fa-home me-1 fs-15"></i> Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('sale_orders.index') }}">
                            <i class="fas fa-list me-1 fs-15"></i> Sale Orders
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create Sale Order</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row">
        <div class="col-12">
            <div class="bg-white p-4 shadow-sm rounded">
                {{-- <form action="{{ route('sale_orders.store') }}" method="POST">
                    @csrf
                    <!-- Grid Form Layout -->
                    <div class="row g-3 mb-4">
                        <!-- Sale Order No. -->
                        <div class="col-md-6">
                            <label for="sale_order_no" class="form-label"><i class="ri-truck-line"></i> Sale Order No.</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-truck-line"></i></span>
                                <input type="text" name="sale_order_no" id="sale_order_no" class="form-control" value="{{ $saleOrderNo }}" readonly>
                            </div>
                        </div> 

                        <!-- Date -->
                        <div class="col-md-6">
                            <label for="date" class="form-label"><i class="ri-calendar-line"></i> Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> 

                        <!-- Customer -->
                        <div class="col-md-6">
                            <label for="customer_id" class="form-label"><i class="ri-user-line"></i> Select Customer <span class="text-danger">*</span></label>
                            <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Agent/User -->
                        <div class="col-md-6">
                            <label for="agent_id" class="form-label"><i class="ri-user-line"></i> Select Agent/User <span class="text-danger">*</span></label>
                            <select name="agent_id" id="agent_id" class="form-select @error('agent_id') is-invalid @enderror" required>
                                <option value="">Select Agent/User</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                        {{ $agent->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('agent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Segment -->
                        <div class="col-md-6">
                            <label for="segment_id" class="form-label"><i class="ri-folder-line"></i> Select Segment <span class="text-danger">*</span></label>
                            <select name="segment_id" id="segment_id" class="form-select @error('segment_id') is-invalid @enderror" required>
                                <option value="">Select Segment</option>
                                @foreach ($segments as $segment)
                                    <option value="{{ $segment->id }}" {{ old('segment_id') == $segment->id ? 'selected' : '' }}>
                                        {{ $segment->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('segment_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lead Source -->
                        <div class="col-md-6">
                            <label for="lead_source_id" class="form-label"><i class="bi bi-clipboard me-1 fs-15"></i> Select Lead Source <span class="text-danger">*</span></label>
                            <select name="lead_source_id" id="lead_source_id" class="form-select @error('lead_source_id') is-invalid @enderror" required>
                                <option value="">Select Lead Source</option>
                                @foreach($leadSources as $leadSource)
                                    <option value="{{ $leadSource->id }}" {{ old('lead_source_id') == $leadSource->id ? 'selected' : '' }}>
                                        {{ $leadSource->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lead_source_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Order Branch -->
                        <div class="col-md-6">
                            <label for="order_branch_id" class="form-label"><i class="bi bi-building me-1"></i> Order Branch <span class="text-danger">*</span></label>
                            <select name="order_branch_id" id="order_branch_id" class="form-select @error('order_branch_id') is-invalid @enderror" required>
                                <option value="">Select Order Branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('order_branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('order_branch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Delivery Branch -->
                        <div class="col-md-6">
                            <label for="delivery_branch_id" class="form-label"><i class="bi bi-building me-1"></i> Delivery Branch <span class="text-danger">*</span></label>
                            <select name="delivery_branch_id" id="delivery_branch_id" class="form-select @error('delivery_branch_id') is-invalid @enderror" required>
                                <option value="">Select Delivery Branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('delivery_branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('delivery_branch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h4 class="text-secondary"><i class="ri-shopping-cart-line"></i> Sales Items</h4>
                            <div class="table-responsive mb-4">
                                <table id="productsTable" class="table table-bordered">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th>Product</th>
                                            <th>Expected Date</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Discount (%)</th>
                                            <th>Sub Total</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="product-row">
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-product-hunt-line"></i></span>
                                                    <select name="products[0][product_id]" class="form-select product-select">
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" {{ old('products.0.product_id') == $product->id ? 'selected' : '' }}>
                                                                {{ $product->product_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('products.*.product_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="date" name="products[0][expected_date]" class="form-control @error('products.*.expected_date') is-invalid @enderror" value="{{ old('products.0.expected_date') }}">
                                            </td>
                                            <td>
                                                <input type="number" name="products[0][quantity]" class="form-control @error('products.*.quantity') is-invalid @enderror" value="{{ old('products.0.quantity') }}" placeholder="enter quantity">
                                            </td>
                                            <td>
                                                <input type="number" name="products[0][price]" class="form-control @error('products.*.price') is-invalid @enderror" value="{{ old('products.0.price') }}" placeholder="enter price">
                                            </td>
                                            <td>
                                                <input type="number" name="products[0][discount]" class="form-control @error('products.*.discount') is-invalid @enderror" value="{{ old('products.0.discount') }}" placeholder="enter discount">
                                            </td>
                                            <td class="subtotal">
                                                <input type="text" name="products[0][subtotal]" class="form-control" placeholder="sub total" readonly>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-product"><i class="ri-delete-bin-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-info btn-sm mt-2 add-product"><i class="add-product ri-add-line"></i> Add Product
                                </button>
                            </div>
                            <!-- Net Amount -->
                            <div class="mb-3">
                                <label for="net_amount" class="form-label"><i class="ri-money-dollar-circle-line"></i> Net Amount <span class="text-danger">*</span></label>
                                <input type="number" name="net_amount" id="net_amount" class="form-control @error('net_amount') is-invalid @enderror" value="{{ old('net_amount') }}" required readonly>
                                @error('net_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>     

                    <!-- Submit Button -->
                    <div class="mb-3">
                        <button type="submit" class="btn btn-secondary"><i class="ri-save-line"></i> Save Sale Order</button>
                    </div>

                </form> --}}
                <div>
                    @livewire('inv-management.sale-order-form')
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let productRowIndex = 0;  // Start with index 0

        function calculateSubtotal(row) {
            const quantity = parseFloat(row.querySelector('input[name$="[quantity]"]').value) || 0;
            const price = parseFloat(row.querySelector('input[name$="[price]"]').value) || 0;
            const discount = parseFloat(row.querySelector('input[name$="[discount]"]').value) || 0;

            const subtotal = (quantity * price) - ((quantity * price) * (discount / 100));
            row.querySelector('input[name$="[subtotal]"]').value = subtotal.toFixed(2);

            calculateNetAmount();
        }

        function calculateNetAmount() {
            let netAmount = 0;
            document.querySelectorAll('#productsTable tbody .product-row').forEach(row => {
                const subtotal = parseFloat(row.querySelector('input[name$="[subtotal]"]').value) || 0;
                netAmount += subtotal;
            });
            document.querySelector('#net_amount').value = netAmount.toFixed(2);
        }

        function createNewProductRow(index) {
            return `
                <tr class="product-row">
                    <td>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-product-hunt-line"></i></span>
                            <select name="products[${index}][product_id]" class="form-select product-select">
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('products.*.product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </td>
                    <td>
                        <input type="date" name="products[${index}][expected_date]" class="form-control @error('products.*.expected_date') is-invalid @enderror">
                    </td>
                    <td>
                        <input type="number" name="products[${index}][quantity]" class="form-control @error('products.*.quantity') is-invalid @enderror" placeholder="enter quantity">
                    </td>
                    <td>
                        <input type="number" name="products[${index}][price]" class="form-control @error('products.*.price') is-invalid @enderror" placeholder="enter price">
                    </td>
                    <td>
                        <input type="number" name="products[${index}][discount]" class="form-control @error('products.*.discount') is-invalid @enderror" placeholder="enter discount">
                    </td>
                    <td class="subtotal">
                        <input type="text" name="products[${index}][subtotal]" class="form-control" placeholder="sub total" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-product"><i class="ri-delete-bin-line"></i>
                        </button>
                    </td>
                </tr>
            `;
        }

        function addProductRow() {
            const rows = document.querySelectorAll('#productsTable tbody .product-row');
            const newIndex = rows.length;
            const newRow = createNewProductRow(newIndex);
            document.querySelector('#productsTable tbody').insertAdjacentHTML('beforeend', newRow);
            productRowIndex = newIndex + 1;
        }

        document.querySelector('#productsTable').addEventListener('input', function (event) {
            if (event.target.matches('input[name$="[quantity]"], input[name$="[price]"], input[name$="[discount]"]')) {
                calculateSubtotal(event.target.closest('.product-row'));
            }
        });

        document.querySelector('.add-product').addEventListener('click', function () {
            addProductRow();
        });

        document.querySelector('#productsTable').addEventListener('click', function (event) {
            if (event.target.matches('.remove-product')) {
                event.target.closest('.product-row').remove();
                calculateNetAmount();
            }
        });

        // Initialize with one row if none exists
        if (document.querySelectorAll('#productsTable tbody .product-row').length === 0) {
            addProductRow();
        }
    });
</script>
@endpush --}}

@endsection


