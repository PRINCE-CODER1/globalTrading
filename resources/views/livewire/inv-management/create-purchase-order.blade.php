<div>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mt-5 mb-2">
                <h2 class="mb-0">Create Purchase Order</h2>
                <a href="{{ route('purchase_orders.index') }}" class="btn btn-outline-secondary">
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
                        <label for="purchase_order_no" class="form-label">Purchase Order No</label>
                        <input type="text" class="form-control" wire:model="purchase_order_no" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="GTE_PO_NO" class="form-label">GTE_PO_NO</label>
                        <input type="text" class="form-control" id="GTE_PO_NO" wire:model="GTE_PO_NO" placeholder="Enter Number : GTE-PO-001" >
                        {{-- @error('GTE_PO_NO')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror --}}
                    </div>

                    <div class="col-md-4">
                        <label for="date" class="form-label">Date</label>
                        <input type="datetime-local" class="form-control" wire:model="date" required>
                    </div>

                    <div class="col-md-4">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <select class="form-select" wire:model="supplier_id" required>
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="supplier_sale_order_no" class="form-label">Supplier Sale Order No</label>
                        <input type="text" class="form-control" wire:model="supplier_sale_order_no" placeholder="Enter supplier number">
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
                                    <!-- Product Selection with Modal -->
                                    <td>
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#productModal-{{ $index }}">
                                            {{ $items[$index]['product_name'] ?? 'Select Product' }}
                                        </button>

                                        <!-- Product Modal -->
                                        <div wire:ignore.self class="modal fade" id="productModal-{{ $index }}" tabindex="-1" aria-labelledby="productModalLabel-{{ $index }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="productModalLabel-{{ $index }}">Select Product</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Search Products -->
                                                        <input type="text" class="form-control mb-3" placeholder="Search Products" wire:model.live="productSearch">
                                                        
                                                        <!-- Product List -->
                                                        <ul class="list-group">
                                                            @foreach($products as $product)
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    {{ $product->product_name }}
                                                                    <button type="button" class="btn btn-sm btn-danger" wire:click="selectProduct({{ $index }}, {{ $product->id }})" data-bs-dismiss="modal">
                                                                        Select
                                                                    </button>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Quantity -->
                                    <td>
                                        <input type="number" class="form-control" wire:model.live="items.{{ $index }}.quantity" wire:change="calculateAmount({{ $index }})" placeholder="Quantity" required>
                                    </td>

                                    <!-- Price -->
                                    <td>
                                        <input type="number" class="form-control" wire:model.live="items.{{ $index }}.price" wire:change="calculateAmount({{ $index }})" placeholder="Price" required>
                                    </td>

                                    <!-- Discount -->
                                    <td>
                                        <input type="number" class="form-control" wire:model.live="items.{{ $index }}.discount" wire:change="calculateAmount({{ $index }})" placeholder="Discount">
                                    </td>

                                    <!-- Amount -->
                                    <td>
                                        <input type="number" class="form-control" wire:model.live="items.{{ $index }}.amount" readonly>
                                    </td>

                                    <!-- Action -->
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" wire:click="removeItem({{ $index }})"><i class="ri-delete-bin-line"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-secondary btn-sm" wire:click="addItem"><i class="ri-add-circle-line"></i> Add Product</button>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-secondary"><i class="ri-save-3-line"></i> Create Purchase Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
