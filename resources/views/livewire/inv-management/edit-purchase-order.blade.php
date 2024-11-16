<div class="container my-5">
    <div class="bg-white p-4 shadow-sm rounded">
        <form wire:submit.prevent="update">
            <!-- Purchase Order Number -->
            <div class="mb-3">
                <label for="purchase_order_no" class="form-label">Purchase Order No</label>
                <input type="text" id="purchase_order_no" wire:model="purchase_order_no" class="form-control" />
                @error('purchase_order_no') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        
            <!-- Date -->
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" id="date" wire:model="date" class="form-control" />
                @error('date') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        
            <!-- Supplier -->
            <div class="mb-3">
                <label for="supplier_id" class="form-label">Supplier</label>
                <select id="supplier_id" wire:model="supplier_id" class="form-select">
                    <option value="">Select a supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
                @error('supplier_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        
            <!-- Agent -->
            <div class="mb-3">
                <label for="agent_id" class="form-label">Agent</label>
                <select id="agent_id" wire:model="agent_id" class="form-select">
                    <option value="">Select an agent</option>
                    @foreach ($agents as $agent)
                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                    @endforeach
                </select>
                @error('agent_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        
            <!-- Segment -->
            <div class="mb-3">
                <label for="segment_id" class="form-label">Segment</label>
                <select id="segment_id" wire:model.live="segment_id" class="form-select">
                    <option value="">Select a segment</option>
                    @foreach ($segments as $segment)
                        <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                    @endforeach
                </select>
                @error('segment_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <!-- Sub Segment -->
            <div class="mb-3">
                <label for="sub_segment_id" class="form-label">Sub-segment</label>
                <select id="sub_segment_id" wire:model="sub_segment_id" class="form-select">
                    <option value="">Select a sub-segment</option>
                    @foreach ($sub_segments as $segment)
                        <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                    @endforeach
                </select>
                @error('sub_segment_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        
            <!-- Order Branch -->
            <div class="mb-3">
                <label for="order_branch_id" class="form-label">Order Branch</label>
                <select id="order_branch_id" wire:model.live="order_branch_id" class="form-select">
                    <option value="">Select an order branch</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
                @error('order_branch_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        
            <!-- Delivery Branch -->
            <div class="mb-3">
                <label for="delivery_branch_id" class="form-label">Delivery Branch</label>
                <select id="delivery_branch_id" wire:model.live="delivery_branch_id" class="form-select">
                    <option value="">Select a delivery branch</option>
                    @foreach ($godowns as $godown)
                        <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                    @endforeach
                </select>
                @error('delivery_branch_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        
            <!-- Customer -->
            <div class="mb-3">
                <label for="customer_id" class="form-label">Customer</label>
                <select id="customer_id" wire:model="customer_id" class="form-select">
                    <option value="">Select a customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
                @error('customer_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        
            <!-- Customer Sale Order No -->
            <div class="mb-3">
                <label for="customer_sale_order_no" class="form-label">Customer Sale Order No</label>
                <input type="text" id="customer_sale_order_no" wire:model="customer_sale_order_no" class="form-control" />
                @error('customer_sale_order_no') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        
            <!-- Customer Sale Order Date -->
            <div class="mb-3">
                <label for="customer_sale_order_date" class="form-label">Customer Sale Order Date</label>
                <input type="date" id="customer_sale_order_date" wire:model="customer_sale_order_date" class="form-control" />
                @error('customer_sale_order_date') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        
            <!-- Items Table -->
            <div class="mb-3">
                <label class="form-label">Items</label>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount (%)</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $index => $item)
                            <tr>
                                <td>
                                    <select wire:model="items.{{ $index }}.product_id" class="form-select">
                                        <option value="">Select a product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                    @error("items.$index.product_id") <div class="text-danger">{{ $message }}</div> @enderror
                                </td>
                                <td><input type="number" wire:model="items.{{ $index }}.quantity" class="form-control" placeholder="Quantity" /></td>
                                <td><input type="number" wire:model="items.{{ $index }}.price" class="form-control" placeholder="Price" /></td>
                                <td><input type="number" wire:model="items.{{ $index }}.discount" class="form-control" placeholder="Discount (%)" /></td>
                                <td>{{ number_format($item['amount'], 2) }}</td>
                                <td class="text-center">
                                    <button type="button" wire:click="removeItem({{ $index }})" class="btn btn-danger btn-sm"><i class="ri-delete-bin-6-line"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" wire:click="addItem" class="btn btn-info btn-sm mt-2"><i class="ri-add-line"></i> Add Item</button>
            </div>
        
            <!-- Subtotal -->
            <div class="mb-3">
                <label for="subtotal" class="form-label">Subtotal</label>
                <input type="text" id="subtotal" wire:model="subtotal" class="form-control" readonly />
            </div>
        
            <!-- Submit Button -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-secondary"><i class="ri-save-3-line"></i> Update Purchase Order</button>
                <a href="{{ route('purchase_orders.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
        
    </div>
</div>



