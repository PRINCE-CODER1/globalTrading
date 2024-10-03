<div>
    <h2 class="mb-0 fw-bold">External <span class="text-secondary"><u>Chalaan</u></span> : {{$reference_id}}</h2>
    <hr>
    <div class="card">
        <div class="card-body">
                <form wire:submit.prevent="create">
                    <div class="mb-4">
                        <label for="chalaan_type_id">Chalaan Type</label>
                        <select wire:model="chalaan_type_id" id="chalaan_type_id" class="form-control">
                            <option value="">Select Chalaan Type</option>
                            @foreach($chalaanTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('chalaan_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
            
                    <div class="mb-4">
                        <label for="customer_id">Customer</label>
                        <select wire:model="customer_id" id="customer_id" class="form-control">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
            
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Branch</th>
                                    <th>Godown</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $index => $product)
                                    <tr>
                                        <td>
                                            <select wire:model.live="products.{{ $index }}.branch_id" class="form-control">
                                                <option value="">Select Branch</option>
                                                @foreach($branches as $branch)
                                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('products.'.$index.'.branch_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td>
                                            <select wire:model.live="products.{{ $index }}.godown_id" class="form-control">
                                                <option value="">Select Godown</option>
                                                @foreach($godowns[$index] ?? [] as $godown)
                                                    <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('products.'.$index.'.godown_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td>
                                            <select wire:model="products.{{ $index }}.product_id" class="form-control">
                                                <option value="">Select Product</option>
                                                @foreach($availableProducts[$index] ?? [] as $product)
                                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('products.'.$index.'.product_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td>
                                            <input type="number" wire:model="products.{{ $index }}.quantity" class="form-control" min="1" placeholder="quantity">
                                            @error('products.'.$index.'.quantity') <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td>
                                            <button type="button" wire:click.prevent="removeProduct({{ $index }})" class="btn btn-sm btn-danger"><i class="ri-delete-bin-5-line"></i> Remove</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="button" wire:click.prevent="addProduct" class="btn btn-info btn-sm mb-3 mt-1"><i class="ri-add-circle-line"></i> Add Product</button>
                    </div>
            
                    <button type="submit" class="btn btn-secondary"><i class="ri-save-3-line"></i> Create External Chalaan</button>
                </form>
            
        </div>
    </div>
</div>
