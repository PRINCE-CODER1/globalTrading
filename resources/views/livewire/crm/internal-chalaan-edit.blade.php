<div class="container mt-2">
    <h2 class="mb-4">Edit Internal Chalaan</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @elseif (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="update" class="bg-white p-4 border rounded shadow-sm">
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="chalaan_type_id" class="form-label fw-semibold">Chalaan Type</label>
                <select wire:model="chalaan_type_id" id="chalaan_type_id" required class="form-select">
                    <option value="">Select Chalaan Type</option>
                    @foreach($chalaanTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('chalaan_type_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3 mb-3">
                <label for="reference_id" class="form-label fw-semibold">Reference ID</label>
                <input type="text" wire:model="reference_id" id="reference_id" readonly class="form-control bg-light" />
            </div>

            <div class="col-md-3 mb-3">
                <label for="from_branch_id" class="form-label fw-semibold">From Branch</label>
                <select wire:model.live="from_branch_id" id="from_branch_id" required class="form-select">
                    <option value="">Select From Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
                @error('from_branch_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3 mb-3">
                <label for="to_branch_id"  class="form-label fw-semibold">To Branch</label>
                <select wire:model.live="to_branch_id" id="to_branch_id" required class="form-select">
                    <option value="">Select To Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
                @error('to_branch_id') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <h3 class="mt-4">Products</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>From Godown</th>
                    <th>To Godown</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index => $product)
                    <tr>
                        <td>
                            <select wire:model.live="products.{{ $index }}.from_godown_id" required class="form-select">
                                <option value="">Select From Godown</option>
                                @foreach($from_godowns as $godown)
                                    <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select wire:model="products.{{ $index }}.to_godown_id" required class="form-select">
                                <option value="">Select To Godown</option>
                                @foreach($to_godowns as $godown)
                                    <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select wire:model="products.{{ $index }}.product_id" required class="form-select">
                                <option value="">Select Product</option>
                                @foreach($availableProducts as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" wire:model="products.{{ $index }}.quantity" required min="1" class="form-control" />
                        </td>
                        <td>
                            <button type="button" wire:click="removeProduct({{ $index }})" class="btn btn-danger btn-sm">Remove</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" wire:click="addProduct" class="btn btn-info btn-sm">Add Product</button>

        <div class="mt-4">
            <button type="submit" class="btn btn-secondary">Update Chalaan</button>
            <a href="{{ route('internal.index') }}" class="btn btn-outline-danger">Back to List</a>
        </div>
    </form>
</div>
