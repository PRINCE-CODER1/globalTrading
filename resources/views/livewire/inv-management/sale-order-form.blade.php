<div>
    <form wire:submit.prevent="submit">
        <!-- Grid Form Layout -->
        <div class="row g-3 mb-4">
            <!-- Sale Order No. -->
            <div class="col-md-6">
                <label for="sale_order_no" class="form-label"><i class="ri-truck-line"></i> Sale Order No.</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ri-truck-line"></i></span>
                    <input type="text" id="sale_order_no" class="form-control" wire:model.defer="saleOrderNo" readonly>
                </div>
            </div> 

            <!-- Date -->
            <div class="col-md-6">
                <label for="date" class="form-label"><i class="ri-calendar-line"></i> Date <span class="text-danger">*</span></label>
                <input type="date" id="date" class="form-control @error('date') is-invalid @enderror" wire:model.defer="date" required>
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> 

            <!-- Customer -->
            <div class="col-md-6">
                <label for="customer_id" class="form-label"><i class="ri-user-line"></i> Select Customer <span class="text-danger">*</span></label>
                <select id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" wire:model.defer="customer_id" required>
                    <option value="">Select Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">
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
                <select id="agent_id" class="form-select @error('agent_id') is-invalid @enderror" wire:model.defer="agent_id" required>
                    <option value="">Select Agent/User</option>
                    @foreach ($agents as $agent)
                        <option value="{{ $agent->id }}">
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
                <select id="segment_id" class="form-select @error('segment_id') is-invalid @enderror" wire:model.live.defer="segment_id" required>
                    <option value="">Select Segment</option>
                    @foreach ($segments as $segment)
                        <option value="{{ $segment->id }}">
                            {{ $segment->name }}
                        </option>
                    @endforeach
                </select>
                @error('segment_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!-- Sub Segment -->
            <div class="col-md-6 mt-3">
                <label for="subsegment_id" class="form-label"><i class="ri-folder-line"></i> Select Sub-Segment <span class="text-danger">*</span></label>
                <select id="subsegment_id" class="form-select @error('sub_segment_id') is-invalid @enderror" wire:model.defer="sub_segment_id">
                    <option value="">Select Sub-Segment</option>
                    @foreach ($subsegments  as $subSegment)
                        <option value="{{ $subSegment->id }}">
                            {{ $subSegment->name }}
                        </option>
                    @endforeach
                </select>
                @error('subsegment_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Lead Source -->
            <div class="col-md-6">
                <label for="lead_source_id" class="form-label"><i class="ri-phone-line"></i> Select Lead Source <span class="text-danger">*</span></label>
                <select id="lead_source_id" class="form-select @error('lead_source_id') is-invalid @enderror" wire:model.defer="lead_source_id" required>
                    <option value="">Select Lead Source</option>
                    @foreach ($leadSources as $leadSource)
                        <option value="{{ $leadSource->id }}">
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
                <label for="order_branch_id" class="form-label"><i class="ri-building-line"></i> Select Order Branch <span class="text-danger">*</span></label>
                <select id="order_branch_id" class="form-select @error('order_branch_id') is-invalid @enderror" wire:model.live="order_branch_id" required>
                    <option value="">Select Order Branch</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">
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
                <label for="delivery_branch_id" class="form-label"><i class="ri-building-line"></i> Select Delivery Branch <span class="text-danger">*</span></label>
                <select id="delivery_branch_id" class="form-select @error('delivery_branch_id') is-invalid @enderror" wire:model.live="delivery_branch_id" required>
                    <option value="">Select Delivery Godown</option>
                    @foreach ($godowns as $godown)
                        <option value="{{ $godown->id }}">
                            {{ $godown->godown_name }}
                        </option>
                    @endforeach
                </select>
                @error('delivery_branch_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!-- Application  -->
            <div class="col-md-3">
                <label for="application" class="form-label fw-semibold">Application</label>
                <select id="application" wire:model="application_id" class="form-select form-select-sm" required>
                    <option value="">Select application</option>
                    @foreach($applications as $application)
                        <option value="{{ $application->id }}">{{ $application->name }}</option>
                    @endforeach
                </select>
                @error('application') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Product Details -->
        <div class="mb-4">
            <h4 class="mb-3">Product Details</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Expected Date</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Discount (%)</th>
                        <th>Subtotal</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>
                                <select class="form-select @error('products.' . $index . '.product_id') is-invalid @enderror" wire:model="products.{{ $index }}.product_id">
                                    <option value="">Select Product</option>
                                    @foreach ($productsList as $prod)
                                        <option value="{{ $prod->id }}">{{ $prod->product_name }}</option>
                                    @endforeach
                                </select>
                                @error('products.' . $index . '.product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="date" class="form-control @error('products.' . $index . '.expected_date') is-invalid @enderror" wire:model="products.{{ $index }}.expected_date">
                                @error('products.' . $index . '.expected_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="number" class="form-control @error('products.' . $index . '.quantity') is-invalid @enderror" wire:model.live="products.{{ $index }}.quantity">
                                @error('products.' . $index . '.quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="number" class="form-control @error('products.' . $index . '.price') is-invalid @enderror" wire:model.live.defer="products.{{ $index }}.price">
                                @error('products.' . $index . '.price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="number" class="form-control @error('products.' . $index . '.discount') is-invalid @enderror" wire:model.live="products.{{ $index }}.discount">
                                @error('products.' . $index . '.discount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                {{ number_format($product['subtotal'], 2) }} 
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm" wire:click="removeProduct({{ $index }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <button type="button" class="btn btn-info btn-sm mt-1" wire:click="addProduct">
                <i class="bi bi-plus-circle"></i> Add Product
            </button>
        </div>

        <!-- Net Amount -->
        <div class="mb-4">
            <h4>Net Amount</h4>
            <input type="text" class="form-control" value="{{ number_format($netAmount, 2) }}" readonly>
        </div>

        <!-- Submit Button -->
        <div class="mb-4">
            <button type="submit" class="btn btn-secondary">
                create sale order
            </button>
        </div>
    </form>
</div>
