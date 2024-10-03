<div class="container mx-auto mt-5">
    <h2 class="text-2xl font-bold mb-4">Create Internal Chalaan</h2>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-4 mb-4 rounded">
            {{ session('message') }}
        </div>
    @elseif (session()->has('error'))
        <div class="bg-red-500 text-white p-4 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="create">
        <div class="mb-4">
            <label for="chalaan_type_id" class="block text-sm font-medium text-gray-700">Chalaan Type</label>
            <select wire:model="chalaan_type_id" id="chalaan_type_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500">
                <option value="">Select Chalaan Type</option>
                @foreach($chalaanTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @error('chalaan_type_id') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="reference_id" class="block text-sm font-medium text-gray-700">Reference ID</label>
            <input type="text" wire:model="reference_id" id="reference_id" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div class="mb-4">
            <label for="from_branch_id" class="block text-sm font-medium text-gray-700">From Branch</label>
            <select wire:model="from_branch_id" id="from_branch_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500">
                <option value="">Select From Branch</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
            @error('from_branch_id') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="to_branch_id" class="block text-sm font-medium text-gray-700">To Branch</label>
            <select wire:model="to_branch_id" id="to_branch_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500">
                <option value="">Select To Branch</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
            @error('to_branch_id') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-semibold">Products</h3>
            @foreach($products as $index => $product)
                <div class="border p-4 rounded mb-2">
                    <div class="mb-2">
                        <label for="products.{{ $index }}.from_godown_id" class="block text-sm font-medium text-gray-700">From Godown</label>
                        <select wire:model.live="products.{{ $index }}.from_godown_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500">
                            <option value="">Select From Godown</option>
                            @foreach($godowns as $godown)
                                <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                            @endforeach
                        </select>
                        @error("products.$index.from_godown_id") <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="products.{{ $index }}.to_godown_id" class="block text-sm font-medium text-gray-700">To Godown</label>
                        <select wire:model.live="products.{{ $index }}.to_godown_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500">
                            <option value="">Select To Godown</option>
                            @foreach($godowns as $godown)
                                <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                            @endforeach
                        </select>
                        @error("products.$index.to_godown_id") <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="products.{{ $index }}.product_id" class="block text-sm font-medium text-gray-700">Product</label>
                        <select wire:model="products.{{ $index }}.product_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500">
                            <option value="">Select Product</option>
                            @if(isset($availableProducts[$index]))
                                @foreach($availableProducts[$index] as $availableProduct)
                                    <option value="{{ $availableProduct->id }}">{{ $availableProduct->product_name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error("products.$index.product_id") <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label for="products.{{ $index }}.quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" wire:model="products.{{ $index }}.quantity" id="products.{{ $index }}.quantity" required min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error("products.$index.quantity") <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <button type="button" wire:click="removeProduct({{ $index }})" class="text-red-500">Remove Product</button>
                </div>
            @endforeach

            <button type="button" wire:click="addProduct" class="bg-blue-500 text-white px-4 py-2 rounded">Add Product</button>
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Create Chalaan</button>
            <a href="{{ route('internal.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded ml-2">Back to List</a>
        </div>
    </form>
</div>
