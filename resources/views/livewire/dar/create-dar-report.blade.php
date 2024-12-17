<div>
    <form wire:submit.prevent="submit">
        {{-- <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select wire:model="customer_id" id="customer_id" class="form-control">
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
            @error('customer_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div> --}}
        <div class="relative w-80 mb-4">
            <!-- Search Input -->
            <label for="customer" class="form-label">Customer</label>
            <input type="text" 
                   wire:model.live="search" 
                   id="customer" 
                   placeholder="Search customers by name..." 
                   class="form-control form-control-sm border rounded" 
                   autocomplete="off" 
                   wire:focus="showDropdown" 
                   wire:blur="hideDropdown" />

            <!-- Dropdown List -->
            @if (!empty($filteredCustomers))
                <div class="absolute z-50 w-full bg-white border rounded shadow mt-1">
                    @foreach ($filteredCustomers as $key => $customer)
                        <div wire:click="selectCustomer({{ $customer['id'] }})"
                             class="p-2 cursor-pointer hover:bg-gray-200">
                            <b>{{ $customer['name'] }}</b> - {{ $customer['mobile_no'] }}
                        </div>
                        @if ($key >= 4)
                            @break
                        @endif
                    @endforeach
                </div>
            @endif

            <!-- Selected Customer Display -->
            @if ($selectedCustomer)
                <div class="mt-2 p-2 bg-green-100 border rounded">
                    <strong>Selected:</strong> {{ $selectedCustomer['name'] }}
                </div>
            @endif
            @error('customer_id') 
                <span class="text-danger">{{ $message }}</span> 
            @enderror
        </div>
        @if($selectedCustomerUsers)
            <div class="col-md-12">
                <label for="customer_user" class="form-label fw-semibold">Customer User</label>
                <select wire:model="customer_supplier_user_id" id="customer_user" class="form-select form-select-sm">
                    <option value="">Select Customer User</option>
                    @foreach($selectedCustomerUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                @error('customer_supplier_user_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        @endif
        <div class="mb-3">
            <label for="pov_id" class="form-label fw-semibold">Purpose of Visit</label>
            <select wire:model="pov_id" id="pov_id" class="form-select form-select-sm">
                <option value="">Select Purpose</option>
                @foreach($purposes as $purpose)
                    <option value="{{ $purpose->id }}">{{ $purpose->visitor_name }}</option>
                @endforeach
            </select>
            @error('pov_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="remarks" class="form-label fw-semibold">Remarks</label>
            <textarea wire:model="remarks" id="remarks" class="form-control" placeholder="enter remarks here"></textarea>
            @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label fw-semibold">Status</label>
            <select wire:model="status" id="status" class="form-control">
                <option value="0">Inactive</option>
                <option value="1">Active</option>
            </select>
            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <input wire:model="rating" type="number" id="rating" class="form-control" min="1" max="5">
            @error('rating') <span class="text-danger">{{ $message }}</span> @enderror
        </div> --}}

        <div class="mb-3">
            <label for="date" class="form-label fw-semibold">Date</label>
            <input wire:model="date" type="date" id="date" class="form-control">
            @error('date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-secondary"><i class="ri-save-3-line"></i> Submit DAR</button>
    </form>
</div>
