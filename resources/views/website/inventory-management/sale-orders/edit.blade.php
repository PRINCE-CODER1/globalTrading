@extends('website.master')

@section('content')
<div class="container my-5">
    <!-- Header Section -->
    <div class="row mb-2">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Edit Sale Order</h2>
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
                    <li class="breadcrumb-item active" aria-current="page">Edit Sale Order</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="bg-white p-4 shadow-sm rounded">
                <form action="{{ route('sale_orders.update', $saleOrder->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Sale Order No. -->
                    <div class="form-group">
                        <label for="sale_order_no">Sale Order No.</label>
                        <input type="text" name="sale_order_no" id="sale_order_no" class="form-control" value="{{ $saleOrder->sale_order_no }}" readonly>
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label for="date">Date *</label>
                        <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $saleOrder->date) }}" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Customer -->
                    <div class="form-group">
                        <label for="customer_id">Select Customer *</label>
                        <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $saleOrder->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Agent/User -->
                    <div class="form-group">
                        <label for="agent_id">Select Agent/User *</label>
                        <select name="agent_id" id="agent_id" class="form-control @error('agent_id') is-invalid @enderror" required>
                            <option value="">Select Agent/User</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ old('agent_id', $saleOrder->agent_id) == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                            @endforeach
                        </select>
                        @error('agent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Segment -->
                    <div class="form-group">
                        <label for="segment_id">Select Segment *</label>
                        <select name="segment_id" id="segment_id" class="form-control @error('segment_id') is-invalid @enderror" required>
                            <option value="">Select Segment</option>
                            @foreach($segments as $segment)
                                <option value="{{ $segment->id }}" {{ old('segment_id', $saleOrder->segment_id) == $segment->id ? 'selected' : '' }}>{{ $segment->name }}</option>
                            @endforeach
                        </select>
                        @error('segment_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lead Source -->
                    <div class="form-group">
                        <label for="lead_source_id">Select Lead Source *</label>
                        <select name="lead_source_id" id="lead_source_id" class="form-control @error('lead_source_id') is-invalid @enderror" required>
                            <option value="">Select Lead Source</option>
                            @foreach($leadSources as $leadSource)
                                <option value="{{ $leadSource->id }}" {{ old('lead_source_id', $saleOrder->lead_source_id) == $leadSource->id ? 'selected' : '' }}>{{ $leadSource->name }}</option>
                            @endforeach
                        </select>
                        @error('lead_source_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Order Branch -->
                    <div class="form-group">
                        <label for="order_branch_id">Order Branch *</label>
                        <select name="order_branch_id" id="order_branch_id" class="form-control @error('order_branch_id') is-invalid @enderror" required>
                            <option value="">Select Order Branch</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('order_branch_id', $saleOrder->order_branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                        @error('order_branch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Delivery Branch -->
                    <div class="form-group">
                        <label for="delivery_branch_id">Delivery Branch *</label>
                        <select name="delivery_branch_id" id="delivery_branch_id" class="form-control @error('delivery_branch_id') is-invalid @enderror" required>
                            <option value="">Select Delivery Branch</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('delivery_branch_id', $saleOrder->delivery_branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                        @error('delivery_branch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h4 class="text-secondary"><i class="ri-shopping-cart-line"></i> Sales Items</h4>
                            <div class="table-responsive mb-4">
                                <!-- Products Table -->
                                <table id="productsTable" class="table">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th>Products</th>
                                            <th>Expected Date</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Discount (%)</th>
                                            <th>Sub Total</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($saleOrder->items as $index => $item)
                                            <tr class="product-row">
                                                <td>
                                                    <select name="products[{{ $index }}][product_id]" class="form-control @error('products.'.$index.'.product_id') is-invalid @enderror">
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>{{ $product->product_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('products.'.$index.'.product_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td><input type="date" name="products[{{ $index }}][expected_date]" class="form-control" value="{{ $item->expected_date }}" /></td>
                                                <td><input type="number" name="products[{{ $index }}][quantity]" class="form-control quantity" value="{{ $item->quantity }}" /></td>
                                                <td><input type="number" name="products[{{ $index }}][price]" class="form-control price" value="{{ $item->price }}" /></td>
                                                <td><input type="number" name="products[{{ $index }}][discount]" class="form-control discount" value="{{ $item->discount }}" /></td>
                                                <td><input type="text" name="products[{{ $index }}][sub_total]" class="form-control sub-total" value="{{ $item->sub_total }}" readonly /></td>
                                                
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-row"><i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-info btn-sm mt-2" id="addRow"><i class="add-product ri-add-line"></i> Add Product
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary"><i class="ri-save-line"></i> Update Sale Order</button>
                </form>
            </div>
        </div>
    </div>
</div>
    

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let rowCount = {{ $saleOrder->items->count() }};

            document.getElementById('addRow').addEventListener('click', function () {
                let tableBody = document.querySelector('#productsTable tbody');
                let newRow = document.querySelector('.product-row').cloneNode(true);
                newRow.querySelectorAll('input, select').forEach(input => input.value = '');
                newRow.querySelectorAll('input.sub-total').forEach(input => input.value = '');
                newRow.querySelectorAll('input, select').forEach(input => {
                    let name = input.name.replace(/\[\d+\]/, `[${rowCount}]`);
                    input.name = name;
                });
                newRow.querySelector('button.remove-row').addEventListener('click', function () {
                    this.closest('tr').remove();
                });
                tableBody.appendChild(newRow);
                rowCount++;
            });

            document.querySelector('#productsTable').addEventListener('input', function (e) {
            
                if (e.target.classList.contains('quantity') || e.target.classList.contains('price') || e.target.classList.contains('discount')) {
                    updateRow(e.target.closest('tr'));
                }
            });

            function updateRow(row) {
                let quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                let price = parseFloat(row.querySelector('.price').value) || 0;
                let discount = parseFloat(row.querySelector('.discount').value) || 0;
                let subTotal = (quantity * price) - ((quantity * price) * discount / 100);
                row.querySelector('.sub-total').value = subTotal.toFixed(2);
            }

            document.querySelectorAll('.remove-row').forEach(button => {
                button.addEventListener('click', function () {
                    this.closest('tr').remove();
                });
            });
        });
    </script>
@endpush
@endsection
