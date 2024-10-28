<div class="container mt-5">
    <h4>Edit Return Chalaan</h4>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save">
        <div class="mb-3">
            <label for="externalChalaanId" class="form-label">External Chalaan</label>
            <select wire:model="externalChalaanId" id="externalChalaanId" class="form-select">
                <option value="">Select an External Chalaan</option>
                @foreach ($externalChalaans as $chalaan)
                    <option value="{{ $chalaan->id }}">{{ $chalaan->reference_id }}</option>
                @endforeach
            </select>
            @error('externalChalaanId') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div>
            <h5>Selected Products:</h5>
            @foreach ($products as $product)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" wire:model="selectedProducts.{{ $product['id'] }}.isSelected" id="product-{{ $product['id'] }}">
                    <label class="form-check-label" for="product-{{ $product['id'] }}">
                        {{ $product['name'] }} (Available: {{ $product['quantity'] }})
                    </label>
                    <input type="number" wire:model="selectedProducts.{{ $product['id'] }}.quantity" min="1" class="form-control mt-1" placeholder="Quantity">
                    @error('selectedProducts.' . $product['id'] . '.quantity') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            @endforeach
        </div>

        <div class="mb-3">
            <label for="branchId" class="form-label">Branch</label>
            <select wire:model="branchId" id="branchId" class="form-select">
                <option value="">Select a Branch</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
            @error('branchId') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="godownId" class="form-label">Godown</label>
            <select wire:model="godownId" id="godownId" class="form-select">
                <option value="">Select a Godown</option>
                @foreach ($godowns as $godown)
                    <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                @endforeach
            </select>
            @error('godownId') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Return Chalaan</button>
    </form>
</div>
