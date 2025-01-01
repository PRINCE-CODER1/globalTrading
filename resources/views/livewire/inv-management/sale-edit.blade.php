<div>
    <form wire:submit.prevent="update">

        <div class="row">
            <!-- Customer Selection -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="customer_id" class="form-label"><i class="ri-user-line"></i> Select Customer <sup class="text-danger">*</sup></label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-user-line"></i></div>
                        <select wire:model.live="customer_id" id="customer_id" class="form-select" aria-label="Select Customer" required>
                            <option value="">Choose a Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('customer_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Sale Date -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="sale_date" class="form-label"><i class="ri-calendar-line"></i> Sale Date</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-calendar-line"></i></div>
                        <input type="date" wire:model="sale_date" id="sale_date" class="form-control">
                    </div>
                    @error('sale_date') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Branch Selection -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="branch_id" class="form-label"><i class="ri-building-line"></i> Select Branch <sup class="text-danger">*</sup></label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-building-line"></i></div>
                        <select wire:model="branch_id" id="branch_id" class="form-select" aria-label="Select Branch" required>
                            <option value="">Choose a Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('branch_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Sale Order Selection -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="sale_order_id" class="form-label"><i class="ri-file-list-3-line"></i> Sale Order <sup class="text-danger">*</sup></label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-file-list-3-line"></i></div>
                        <select wire:model="sale_order_id" id="sale_order_id" class="form-select" aria-label="Select Sale Order" required>
                            <option value="">Choose a Sale Order</option>
                            @foreach ($saleOrders as $order)
                                <option value="{{ $order->id }}">{{ $order->sale_order_no }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('sale_order_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <!-- Sales Items -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h4 class="text-secondary"><i class="ri-shopping-cart-line me-1"></i> Sales Items</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Godown</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $index => $item)
                                <tr>
                                    <td>
                                        <select wire:model="items.{{ $index }}.product_id" class="form-select">
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                            @endforeach
                                        </select>
                                        @error("items.$index.product_id") <div class="text-danger">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        <input type="number" wire:model="items.{{ $index }}.quantity" class="form-control" placeholder="Quantity">
                                        @error("items.$index.quantity") <div class="text-danger">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        <input type="number" wire:model="items.{{ $index }}.price" class="form-control" placeholder="Price">
                                        @error("items.$index.price") <div class="text-danger">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        <input type="number" wire:model="items.{{ $index }}.discount" class="form-control" placeholder="Discount">
                                        @error("items.$index.discount") <div class="text-danger">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        <select wire:model="items.{{ $index }}.godown_id" class="form-select">
                                            <option value="">Select Godown</option>
                                            @foreach($godowns as $godown)
                                                <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                                            @endforeach
                                        </select>
                                        @error("items.$index.godown_id") <div class="text-danger">{{ $message }}</div> @enderror
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" wire:click="removeItem({{ $index }})">
                                            <i class="ri-delete-bin-6-line"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No sales items added.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-info btn-sm mt-2" wire:click="addItem">
                        <i class="ri-add-line"></i> Add Item
                    </button>
                </div>
            </div>
        </div>

        <!-- Submit and Cancel Buttons -->
        <div class="d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-secondary btn-wave">
                <i class="ri-save-line"></i> Update Sale
            </button>
            <a href="{{ route('sales.index') }}" class="btn btn-danger-ghost btn-wave">
                Cancel
            </a>
        </div>
    </form>
</div>
