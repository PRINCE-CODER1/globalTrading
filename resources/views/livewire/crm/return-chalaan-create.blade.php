<div class="container mb-5">
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
            <h1 class="mb-0 fw-bold">Return Chalaans</h1>
            <a href="{{ route('return-chalaan.index') }}" class="btn btn-secondary btn-wave float-end"><i class="ri-arrow-left-s-line"></i> Back</a>
        </div>
        <hr>
    </div>
    <!-- Success message -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Return Chalaan Form -->
    <form wire:submit.prevent="save" class="shadow p-4 rounded bg-white">
        <h3 class="mb-4 fw-bold">Return <span class="text-secondary"><u>Chalaan</u></span> : {{$returnReferenceId}} </h3>
        

        <div class="mb-3">
            <label for="externalChalaanId" class="form-label fs-14 text-dark">Select External Chalaan</label>
            <select wire:model.live="externalChalaanId" class="form-select" id="externalChalaanId">
                <option value="">Choose Chalaan</option>
                @foreach($externalChalaans as $chalaan)
                    <option value="{{ $chalaan->id }}">{{ $chalaan->reference_id }}</option>
                @endforeach
            </select>
            @error('externalChalaanId') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <input type="hidden" wire:model="returnReferenceId" id="returnReferenceId" class="form-control" required readonly>
            @error('returnReferenceId') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Display Products Related to Selected External Chalaan -->
        @if(!empty($products))
            <h4 class="text-dark">Products in Chalaan :</h4>
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th class="fw-bold">Product Name</th>
                        <th class="fw-bold">Quantity</th>
                        <th class="fw-bold">Return Quantity</th>
                        <th class="fw-bold">Select</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $index => $product)
                        <tr>
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['quantity'] }}</td>
                            <td>
                                <input type="number" wire:model="selectedProducts.{{ $product['id'] }}.edit_quantity" class="form-control" min="1" max="{{ $product['quantity'] }}">
                                @error('selectedProducts.' . $product['id'] . '.edit_quantity') <span class="text-danger">{{ $message }}</span> @enderror
                            </td>
                            <td>
                                <input type="checkbox" class="form-check-input" wire:model="selectedProducts.{{ $product['id'] }}.isSelected">
                                @error('selectedProducts.' . $product['id'] . '.isSelected') <span class="text-danger">{{ $message }}</span> @enderror
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Branch and Godown Selection -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="mb-3">
                    <label for="branchId" class="form-label fs-14 text-dark">Select Branch</label>
                    <select wire:model.live="branchId" class="form-control" id="branchId">
                        <option value="">Choose Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @error('branchId') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="mb-3">
                    <label for="godownId" class="form-label fs-14 text-dark">Select Godown</label>
                    <select wire:model="godownId" class="form-control" id="godownId">
                        <option value="">Choose Godown</option>
                        @foreach($godowns as $godown)
                            <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                        @endforeach
                    </select>
                    @error('godownId') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-secondary btn-block"><i class="ri-save-3-line"></i> Save Return Chalaan</button>
    </form>
</div>
