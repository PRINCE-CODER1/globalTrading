<div class="container mt-4">
    <form wire:submit.prevent="save">
        <!-- Display Validation Errors -->
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
            <!-- Supplier -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="supplier_id" class="form-label"><i class="ri-store-2-line"></i> Select Supplier <sup class="text-danger">*</sup></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-store-2-line"></i></span>
                        <select wire:model.live="supplier_id" id="supplier_id" class="form-select" required>
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
                    <label for="purchase_date" class="form-label"><i class="ri-calendar-line"></i> Purchase Date <sup class="text-danger">*</sup></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-calendar-line"></i></span>
                        <input type="datetime-local" wire:model="purchase_date" id="purchase_date" class="form-control" required>
                    </div>
                    @error('purchase_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Branch -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="branch_id" class="form-label"><i class="ri-building-2-line"></i> Branch <sup class="text-danger">*</sup></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-building-2-line"></i></span>
                        <select wire:model.live="branch_id" id="branch_id" class="form-select" required>
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
                    <label for="purchase_order_id" class="form-label"><i class="ri-clipboard-line"></i> Purchase Order <sup class="text-danger">*</sup></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-clipboard-line"></i></span>
                        <select wire:model.live="purchase_order_id" id="purchase_order_id" class="form-select">
                            <option value="">Choose a purchase order</option>
                            @foreach ($purchaseOrders as $order)
                                <option value="{{ $order->id }}">{{ $order->GTE_PO_NO }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Supplier Sale Order Number -->
            <div class="form-group">
                <label for="supplier_sale_order_no" class="form-label">Supplier Sale Order No</label>
                <select id="supplier_sale_order_no" class="form-select" wire:model.live="supplier_sale_order_no" >
                    <option value="">Select Supplier Sale Order No</option>
                    @foreach ($supplierSaleOrderNos as $id => $orderNo)
                        <option value="{{ $id }}">{{ $orderNo }}</option>
                    @endforeach
                </select>
            </div>
            


            <!-- Reference No -->
            {{-- <div class="col-md-6">
                <div class="mb-3">
                    <label for="ref_no" class="form-label"><i class="ri-hashtag"></i> Reference No</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-hashtag"></i></span>
                        <input type="text" wire:model="ref_no" id="ref_no" class="form-control">
                    </div>
                    @error('ref_no')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div> --}}
            <input type="hidden" wire:model="user_id" value="{{ auth()->user()->id }}">
        </div>

        <!-- Purchase Items -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h4 class="text-secondary"><i class="ri-shopping-cart-line"></i> Purchase Items</h4>
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
                                        <select wire:model="items.{{ $index }}.product_id" class="form-control" wire:change="selectProduct({{ $index }}, $event.target.value)">
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                            @endforeach
                                        </select>
                                        @error("items.$index.product_id") <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        <input type="number" wire:model="items.{{ $index }}.quantity" class="form-control" placeholder="Quantity" required>
                                        @error("items.$index.quantity")
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" wire:model="items.{{ $index }}.price" class="form-control" placeholder="Price" required>
                                        @error("items.$index.price")
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" wire:model="items.{{ $index }}.discount" class="form-control" placeholder="Discount" required>
                                        @error("items.$index.discount")
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" wire:model="items.{{ $index }}.sub_total" class="form-control" readonly>
                                    </td>
                                    <td>
                                        <select wire:model="items.{{ $index }}.godown_id" class="form-select" required>
                                            <option value="">Select Godown</option>
                                            @foreach ($godowns as $godown)
                                                <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                                            @endforeach
                                        </select>
                                        @error("items.$index.godown_id")
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <button type="button" wire:click.prevent="removeItem({{ $index }})" class="btn btn-danger btn-sm">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="button" wire:click.prevent="addItem" class="btn btn-info btn-sm mt-2">
                    <i class="ri-add-line"></i> Add Item
                </button>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-4">
            <button type="submit" class="btn btn-secondary">
                <i class="ri-save-line"></i> Save Purchase
            </button>
        </div>
    </form>
</div>
