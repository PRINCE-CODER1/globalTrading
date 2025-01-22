<div>
    <div class="container">
        <div class="row mt-5 mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h4>Purchase Order Report</h4>
            </div>
        </div>
    </div>
    
    <div class="container my-4">
        <div class="card shadow-sm rounded bg-secondary">
            <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex flex-wrap align-items-center justify-content-start gap-3">
                    

                    <!-- Per Page Filter -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark btn-wave dropdown-toggle fw-bold" data-bs-toggle="dropdown" aria-expanded="false">
                            Per Page: {{ $perPage }}
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ([2, 5, 10, 20] as $size)
                                <li>
                                    <a class="dropdown-item" href="#" wire:click.prevent="updatePerPage({{ $size }})">
                                        {{ $size }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
               <!-- Export Lead -->
                <div class="d-flex justify-content-between gap-3 mb-1 position-relative align-items-center">
                    <!-- Export as Excel -->
                    <button 
                        wire:click="export('xlsx')" 
                        wire:loading.attr="disabled" 
                        class="btn btn-dark btn-wave fw-bold d-flex align-items-center">
                        <i class="ri-file-excel-2-line me-1"></i> Export as Excel
                    </button>
                    
                    <!-- Export as CSV -->
                    <button 
                        wire:click="export('csv')" 
                        wire:loading.attr="disabled" 
                        class="btn btn-dark btn-wave fw-bold d-flex align-items-center">
                        <i class="ri-export-line me-1"></i> Export as CSV
                    </button>
                    
                    <!-- Loading Spinner -->
                    <div wire:loading class="spinner-border text-dark ms-2" role="status" style="width: 1.5rem; height: 1.5rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>



                {{-- Search and Filters Row --}}
                <div class="col-md-12 mt-3">
                    <div class=" d-flex align-items-center justify-content-between">
                        <div class="d-flex gap-3 ">
                            <!-- Search Input -->
                            <div>
                                <input wire:model.live="search" type="text" id="search" class="form-control fw-bold" placeholder="Search">
                            </div>
                            <!-- Date Filters -->
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <label for="" class="text-white fw-bold">Start</label>
                                <input wire:model.live="startDate" type="date" class="form-control fw-bold">
                            </div>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <label for="" class="text-white fw-bold">End</label>
                                <input wire:model.live="endDate" type="date" class="form-control fw-bold">
                            </div>
                        </div>
                        {{-- Reset Filters --}}
                        <div class="d-flex justify-content-end">
                            <button wire:click="resetFilters" class="btn btn-danger fw-bold">
                                <i class="bi bi-arrow-clockwise"></i> Reset Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        
                                            
                        <div class="table-responsive">
                            <table class="table text-nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th>SR. No</th>
                                        <th>Supplier</th>
                                        <th>Invoice No</th>
                                        <th>Invoice Date</th>
                                        <th>Amount</th>
                                        {{-- <th>Order Branch</th> --}}
                                    </tr>
                                </thead>
                                @php $serialNumber = $purchaseOrder->firstItem(); @endphp
                                <tbody>
                                    @forelse ($purchaseOrder as $purchase)
                                        <tr>
                                            <td>{{$serialNumber++}}.</td>
                                            <td>{{$purchase->supplier->name}}</td>
                                            <td>{{$purchase->purchase_order_no}}</td>
                                            <td>{{$purchase->date}}</td>
                                            <td>{{ $purchase->items->sum('price') }}</td>
                                            {{-- <td>{{$purchase->orderBranch->name}}</td> --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                <p class="mb-0">No Records found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3">
                            {{ $purchaseOrder->links('custom-pagination-links') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
