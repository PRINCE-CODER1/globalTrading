<div>
    <div class="container">
        <div class="row mt-5 mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h4>Sale Order Report</h4>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Per Page: {{ $perPage }}
                    </button>
                    <ul class="dropdown-menu">
                        @foreach ([2,10, 20, 50, 100] as $size)
                            <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage({{ $size }})">{{ $size }}</a></li>
                        @endforeach
                    </ul>
                </div>
    
                <!-- Search Input -->
                <div class="d-flex align-items-center">
                    
                    <div class="col-auto">
                        <input wire:model.live="search" type="text" id="search" class="form-control" placeholder="Search">
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
                        <div class="mb-3">
                            <a href="javascript:void(0)" wire:click="export('xlsx')" class="btn btn-secondary">
                                <i class="ri-export-fill"></i> Download Excel
                            </a>
                            <a href="javascript:void(0)" wire:click="export('csv')" class="btn btn-dark">
                                <i class="ri-export-fill"></i> Download CSV
                            </a>
                        </div>
                                            
                        <div class="table-responsive">
                            <table class="table text-nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th>SR. No</th>
                                        <th>Customer</th>
                                        <th>Invoice No</th>
                                        <th>Invoice Date</th>
                                        <th>Amount</th>
                                        <th>Branch Name</th>
                                        <th>Agent</th>
                                        <th>Lead Source</th>
                                        <th>Segment</th>
                                    </tr>
                                </thead>
                                @php $serialNumber = $saleOrder->firstItem(); @endphp
                                <tbody>
                                    @forelse ($saleOrder as $sale)
                                        <tr>
                                            <td>{{ $serialNumber++ }}.</td>
                                            <td>{{$sale->customer->name}}</td>
                                            <td>{{$sale->sale_order_no}}</td>
                                            <td>{{$sale->date}}</td>
                                            <td>{{ $sale->items->sum('sub_total') }}</td>
                                            <td>{{$sale->orderBranch->name}}</td>
                                            <td>{{$sale->agent->name}}</td>
                                            <td>{{$sale->leadSource->name}}</td>
                                            <td>{{$sale->segment->name}}</td>
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
                            <div class="mb-3">
                                {{$saleOrder->links('custom-pagination-links')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
