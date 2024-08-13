<div>
    <h3>Products</h3>
    <button type="button" class="btn btn-primary" wire:click="addProduct">Add Product</button>
    @foreach($products as $index => $product)
        <div class="row mb-2">
            <div class="col-md-4">
                <label for="product_id_{{ $index }}">Product</label>
                <select name="products[{{ $index }}][product_id]" id="product_id_{{ $index }}" class="form-control">
                    @foreach($allProducts as $prod)
                        <option value="{{ $prod->id }}" {{ $prod->id == ($product['product_id'] ?? old('products.' . $index . '.product_id')) ? 'selected' : '' }}>
                            {{ $prod->product_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="expected_date_{{ $index }}">Expected Date</label>
                <input type="date" wire:model="products.{{ $index }}.expected_date" id="expected_date_{{ $index }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label for="quantity_{{ $index }}">Quantity</label>
                <input type="number" wire:model.live="products.{{ $index }}.quantity" id="quantity_{{ $index }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label for="price_{{ $index }}">Price</label>
                <input type="number" step="0.01" wire:model.live="products.{{ $index }}.price" id="price_{{ $index }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label for="discount_{{ $index }}">Discount (%)</label>
                <input type="number" step="0.01" wire:model.live="products.{{ $index }}.discount" id="discount_{{ $index }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label for="sub_total_{{ $index }}">Sub Total</label>
                <input type="text" wire:model="products.{{ $index }}.sub_total" id="sub_total_{{ $index }}" class="form-control" readonly>
            </div>
            <div class="col-md-12">
                <button type="button" class="btn btn-danger" wire:click="removeProduct({{ $index }})">Remove Product</button>
            </div>
        </div>
    @endforeach
</div>
