<div>
    <div class="container">

        @if (session()->has('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="row g-3">
            <!-- Stock Transfer No -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="stock_transfer_no" class="form-label"><i class="ri-hashtag"></i> Stock Transfer No</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-hashtag"></i></div>
                        <input type="text" wire:model="stock_transfer_no" id="stock_transfer_no" class="form-control" readonly style="cursor:not-allowed">
                    </div>
                    @error('stock_transfer_no')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- From Branch -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="from_branch_id" class="form-label"><i class="ri-clipboard-line"></i> From Branch *</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-clipboard-line"></i></div>
                        <select wire:model="from_branch_id" id="from_branch_id" class="form-select" required>
                            <option value="">Select From Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    @error('from_branch_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>
            </div>

            <!-- Stock Transfer Date -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="stock_transfer_date" class="form-label"><i class="ri-calendar-line"></i> Stock Transfer Date</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-calendar-line"></i></div>
                        <input type="date" wire:model="stock_transfer_date" id="stock_transfer_date" class="form-control" required>
                    </div>
                    @error('stock_transfer_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Destination -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="destination" class="form-label"><i class="ri-map-pin-line"></i> Destination</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-map-pin-line"></i></div>
                        <input type="text" wire:model="destination" id="destination" class="form-control">
                    </div>
                    @error('destination')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Dispatch Through -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="dispatch_through" class="form-label"><i class="ri-truck-line"></i> Dispatch Through</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-truck-line"></i></div>
                        <input type="text" wire:model="dispatch_through" id="dispatch_through" class="form-control">
                    </div>
                    @error('dispatch_through')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- G.R. No -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="gr_no" class="form-label"><i class="ri-hashtag"></i> G.R. No.</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-hashtag"></i></div>
                        <input type="text" wire:model="gr_no" id="gr_no" class="form-control">
                    </div>
                    @error('gr_no')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- G.R Date -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="gr_date" class="form-label"><i class="ri-calendar-line"></i> G.R Date</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-calendar-line"></i></div>
                        <input type="date" wire:model="gr_date" id="gr_date" class="form-control">
                    </div>
                    @error('gr_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Weight -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="weight" class="form-label"><i class="ri-scales-line"></i> Weight</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-scales-line"></i></div>
                        <input type="text" wire:model="weight" id="weight" class="form-control">
                    </div>
                    @error('weight')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- No. of Boxes -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="no_of_boxes" class="form-label"><i class="ri-stack-line"></i> No. of Boxes</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-stack-line"></i></div>
                        <input type="number" wire:model="no_of_boxes" id="no_of_boxes" class="form-control">
                    </div>
                    @error('no_of_boxes')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Vehicle No -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="vehicle_no" class="form-label"><i class="ri-truck-line"></i> Vehicle No</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-truck-line"></i></div>
                        <input type="text" wire:model="vehicle_no" id="vehicle_no" class="form-control">
                    </div>
                    @error('vehicle_no')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- To Branch -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="to_branch_id" class="form-label"><i class="ri-clipboard-line"></i> To Branch *</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-clipboard-line"></i></div>
                        <select wire:model.live="to_branch_id" id="to_branch_id" class="form-select" required>
                            <option value="">Select To Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('to_branch_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- To Godown -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="to_godown_id" class="form-label"><i class="ri-clipboard-line"></i> To Godown *</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-clipboard-line"></i></div>
                        <select wire:model.live="to_godown_id" id="to_godown_id" class="form-select" required>
                            <option value="">Select To Godown</option>
                            @foreach ($godowns as $godown)
                                <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('to_godown_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12 d-flex justify-content-start">
                <button type="submit" class="btn btn-secondary"><i class="ri-save-line"></i> Save</button>
            </div>
        </form>

    </div>
</div>
