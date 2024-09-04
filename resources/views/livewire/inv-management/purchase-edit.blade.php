<div>
    <form wire:submit.prevent="update">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-3">
            <!-- Purchase No -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="purchase_no" class="form-label fs-14 text-dark">Purchase No</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-file-list-3-line"></i></div>
                        <input type="text" class="form-control  " id="purchase_no" wire:model="purchaseOrderNo" readonly>
                    </div>
                </div>
            </div>

            <!-- Supplier -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="supplier_id" class="form-label">Select Supplier *</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-user-line"></i></div>
                        <select wire:model.live="supplier_id" id="supplier_id" class="form-select  " required>
                            <option value="">Choose a supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('supplier_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Purchase Date -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="purchase_date" class="form-label">Purchase Date *</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-calendar-line"></i></div>
                        <input type="date" wire:model="purchase_date" id="purchase_date" class="form-control  " required>
                    </div>
                    @error('purchase_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Branch -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="branch_id" class="form-label">Branch *</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-building-line"></i></div>
                        <select wire:model="branch_id" id="branch_id" class="form-select  " required>
                            <option value="">Choose a branch</option>
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

            <!-- Purchase Order -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="purchase_order_id" class="form-label">Purchase Order *</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-file-paper-line"></i></div>
                        <select wire:model="purchase_order_id" id="purchase_order_id" class="form-select  " required>
                            <option value="">Choose a purchase order</option>
                            @foreach ($purchaseOrders as $order)
                                <option value="{{ $order->id }}">{{ $order->purchase_order_no }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('purchase_order_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Reference No -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="ref_no" class="form-label">Reference No</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-hashtag"></i></div>
                        <input type="text" wire:model="ref_no" id="ref_no" class="form-control  ">
                    </div>
                    @error('ref_no')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Destination -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="destination" class="form-label">Destination</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-map-pin-line"></i></div>
                        <input type="text" wire:model="destination" id="destination" class="form-control  ">
                    </div>
                    @error('destination')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Received Through -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="received_through" class="form-label">Received Through</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-truck-line"></i></div>
                        <input type="text" wire:model="received_through" id="received_through" class="form-control  ">
                    </div>
                    @error('received_through')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- GR No -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="gr_no" class="form-label">GR No</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-file-list-line"></i></div>
                        <input type="text" wire:model="gr_no" id="gr_no" class="form-control  ">
                    </div>
                    @error('gr_no')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Purchase Items -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h4 class="text-secondary">Purchase Items</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Sub Total</th>
                                <th>Godown</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $index => $item)
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="ri-shopping-bag-line"></i></div>
                                            <select wire:model="items.{{ $index }}.product_id" class="form-select  " required>
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('items.' . $index . '.product_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="ri-inbox-line"></i></div>
                                            <input type="number" wire:model.live="items.{{ $index }}.quantity" class="form-control  " placeholder="Quantity" required>
                                        </div>
                                        @error('items.' . $index . '.quantity')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="ri-money-dollar-circle-line"></i></div>
                                            <input type="number" wire:model.live="items.{{ $index }}.price" class="form-control  " placeholder="Price" required>
                                        </div>
                                        @error('items.' . $index . '.price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="ri-price-tag-line"></i></div>
                                            <input type="number" wire:model.live="items.{{ $index }}.discount" class="form-control  " placeholder="Discount">
                                        </div>
                                        @error('items.' . $index . '.discount')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" wire:model="items.{{ $index }}.sub_total" class="form-control  " placeholder="Sub Total" readonly>
                                    </td>
                                    <td>
                                        <select wire:model="items.{{ $index }}.godown_id" class="form-select  ">
                                            <option value="">Select Godown</option>
                                            @foreach ($godowns as $godown)
                                                <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" wire:click="removeItem({{ $index }})" class="btn btn-danger btn-sm">
                                            <i class="ri-delete-bin-6-line"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button type="button" wire:click="addItem" class="btn btn-info btn-sm mt-3">
                    <i class="ri-add-line"></i> Add Item
                </button>
            </div>
        </div>
        <!-- Submit Button -->
        <div class="mt-4">
            <button type="submit" class="btn btn-secondary"><i class="ri-save-line"></i> Update Purchase</button>
        </div>
    </form>
</div>
