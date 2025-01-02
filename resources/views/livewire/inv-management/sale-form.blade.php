<div>
    <div class="container">

        <form wire:submit.prevent="save">
            
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <div class="row">
                <!-- Sale No -->
                {{-- <div class="col-md-6">
                    <div class="mb-3">
                        <label for="sale_no" class="form-label"><i class="ri-price-tag-2-line"></i> Sale No <sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-price-tag-2-line"></i></div>
                            <input type="text" wire:model="saleOrderNo" id="saleOrderNo" class="form-control" readonly style="cursor:not-allowed">
                        </div>
                        @error('saleOrderNo')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div> --}}
        
                <!-- Customer Selection -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="customer_id" class="form-label"><i class="ri-user-line"></i> Select Customer <sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-user-line"></i></div>
                            <select wire:model.live="customer_id" id="customer_id" class="form-select" required>
                                <option value="">Choose a Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('customer_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
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
                        @error('sale_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        
        
                <!-- Branch Selection -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="branch_id" class="form-label"><i class="ri-building-line"></i> Select Branch <sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-building-line"></i></div>
                            <select wire:model.live="branch_id" id="branch_id" class="form-select" required>
                                <option value="">Choose a Branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('branch_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        
                <!-- Sale Order Selection -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="sale_order_id" class="form-label"><i class="ri-file-list-3-line"></i> Sale Order <sup class="text-danger">*</sup></label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="ri-file-list-3-line"></i></div>
                            <select wire:model.live="sale_order_id" id="sale_order_id" class="form-select" required>
                                <option value="">Choose a Sale Order</option>
                                @foreach ($saleOrders as $order)
                                    <option value="{{ $order->id }}">{{ $order->sale_order_no }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('sale_order_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <h4 class="text-secondary"><i class="ri-shopping-cart-line"></i> Sales Items</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Discount (%)</th>
                                        <th>Godown</th>
                                        <th>Sub Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $index => $item)
                                        <tr>
                                            <td>
                                                <select wire:model="items.{{ $index }}.product_id" class="form-control" wire:change="selectProduct({{ $index }}, $event.target.value)">
                                                    <option value="">Select Product</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error("items.$index.product_id") <span class="text-danger">{{ $message }}</span> @enderror
                                            </td>
                                            
                                            <td>
                                                <input type="number" wire:model.live="items.{{ $index }}.quantity" class="form-control" placeholder="enter quantity" required>
                                                @error("items.$index.quantity") <span class="text-danger">{{ $message }}</span> @enderror
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" wire:model.live="items.{{ $index }}.price" class="form-control" placeholder="enter price" required>
                                                @error("items.$index.price") <span class="text-danger">{{ $message }}</span> @enderror
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" wire:model.live="items.{{ $index }}.discount" placeholder="enter discount" class="form-control">
                                                @error("items.$index.discount") <span class="text-danger">{{ $message }}</span> @enderror
                                            </td>
                                            <td>
                                                <select wire:model="items.{{$index}}.godown_id" class="form-control">
                                                    <option value="">Select Godown</option>
                                                    @foreach($filteredGodowns as $godown)
                                                        <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error("items.$index.godown_id") <span class="text-danger">{{ $message }}</span> @enderror
                                            </td>
                                            <td>
                                                {{ number_format(
                                                    (floatval($item['quantity']) * floatval($item['price'])) * (1 - floatval($item['discount']) / 100),
                                                    2
                                                ) }}
                                            </td>
                                            
                                            <td>
                                                <button type="button" wire:click="removeItem({{ $index }})" class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i></button>
                                            </td>
                                        </tr>
                                        @empty 
                                        <tr>
                                            <td colspan="8" class="text-center">No sales found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <button type="button" wire:click="addItem" class="btn btn-sm btn-info mt-1"><i class="ri-add-line"></i> Add Item</button>
                    </div>
                </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-secondary"><i class="ri-save-line"></i> Create Sale</button>
            </div>
        </form>
    </div>
</div>
