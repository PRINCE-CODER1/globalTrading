<div>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mt-5 mb-2">
                <h2 class="mb-0 d-flex justify-content-between align-items-center">Create Purchase Order</h2>
                <a href="{{ route('purchase_orders.index') }}" type="button" class="btn btn-outline-secondary">
                    <i class="bi bi-chevron-left me-1"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="bg-white p-4 shadow-sm rounded">
            <form wire:submit.prevent="save">
                <!-- Form Fields -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="purchase_order_no" class="form-label fs-14 text-dark">Purchase Order No</label>
                            <input type="text" class="form-control" wire:model="purchase_order_no" readonly>
                        </div>
                    </div>
                    
                    <!-- Date Field -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="date" class="form-label fs-14 text-dark">Date</label>
                            <input type="date" class="form-control" wire:model="date" required>
                        </div>
                    </div>

                    <!-- Supplier Field -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="supplier_id" class="form-label fs-14 text-dark">Supplier</label>
                            <select class="form-select" wire:model="supplier_id" required>
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
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
                            <input type="text" class="form-control" wire:model="supplier_sale_order_no">
                        </div>
                    </div>

                    <!-- Agent Field -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="agent_id" class="form-label fs-14 text-dark">Agent</label>
                            <select class="form-select" wire:model="agent_id" required>
                                <option value="">Select Agent</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Segment Field -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="segment_id" class="form-label fs-14 text-dark">Segment</label>
                            <select class="form-select" wire:model="segment_id" required>
                                <option value="">Select Segment</option>
                                @foreach($segments as $segment)
                                    <option value="{{ $segment->id }}">{{ $segment->name }}</option>
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
                            <select class="form-select" wire:model.live="order_branch_id" required>
                                <option value="">Select Branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Delivery Branch Field -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="delivery_branch_id" class="form-label fs-14 text-dark">Delivery Godown</label>
                            <select class="form-select" wire:model.live="delivery_branch_id" required>
                                <option value="">Select Godown</option>
                                @foreach($godowns as $godown)
                                    <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
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
                            <select class="form-select" wire:model="customer_id">
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Customer Sale Order No -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_sale_order_no" class="form-label fs-14 text-dark">Customer Sale Order No</label>
                            <input type="text" class="form-control" wire:model="customer_sale_order_no">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <!-- Customer Sale Order Date -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="customer_sale_order_date" class="form-label fs-14 text-dark">Customer Sale Order Date</label>
                            <input type="date" class="form-control" wire:model="customer_sale_order_date">
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <h4 class="mb-3">Products</h4>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Discount (%)</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $index => $item)
                                <tr>
                                    <td>
                                        <select class="form-select" wire:model="items.{{ $index }}.product_id" required>
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" wire:model.live="items.{{ $index }}.quantity" wire:change="calculateAmount({{ $index }})" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" wire:model.live="items.{{ $index }}.price" wire:change="calculateAmount({{ $index }})" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" wire:model.live="items.{{ $index }}.discount" wire:change="calculateAmount({{ $index }})">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" wire:model.live="items.{{ $index }}.amount" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" wire:click="removeItem({{ $index }})"><i class="ri-delete-bin-line"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-secondary mt-1" wire:click="addItem"><i class="ri-add-circle-line"></i> Add Product</button>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-secondary">Create Purchase Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
