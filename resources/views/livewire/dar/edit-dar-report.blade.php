<div>
    <form wire:submit.prevent="update">
        <div class="form-group mb-3">
            <label for="customer_id" class="form-label fw-semibold">Customer</label>
            <select wire:model="customer_id" class="form-control" id="customer_id" disabled>
                <option value="">Select Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
            @error('customer_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group mb-3">
            <label for="cust_sup_user" class="form-label fw-semibold">Select Customer User</label>
            <select wire:model="customer_supplier_user_id" class="form-control" id="cust_sup_user" disabled>
                <option value="">Customer Supplier User</option>
                    @foreach($selectedCustomerUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
            </select>
            @error('customer_supplier_user_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group mb-3">
            <label for="pov_id" class="form-label fw-semibold">Purpose of Visit</label>
            <select wire:model="pov_id" class="form-control" id="pov_id" disabled>
                <option value="">Select Purpose</option>
                @foreach ($purposes as $purpose)
                    <option value="{{ $purpose->id }}">{{ $purpose->visitor_name }}</option>
                @endforeach
            </select>
            @error('pov_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="remarks" class="form-label fw-semibold">Remarks</label>
            <textarea wire:model="remarks" class="form-control" id="remarks"></textarea>
            @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="status" class="form-label fw-semibold">Status</label>
            <select wire:model="status" class="form-control" id="status" >
                <option value="0">Pending</option>
                <option value="1">Completed</option>
            </select>
            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        {{-- <div class="form-group mb-3">
            <label for="rating">Rating</label>
            <input type="number" wire:model="rating" class="form-control" id="rating" min="1" max="5" />
            @error('rating') <span class="text-danger">{{ $message }}</span> @enderror
        </div> --}}

        <button type="submit" class="btn btn-secondary"><i class="ri-save-3-line"></i> Update</button>
    </form>
</div>
