<div>
    <div class="container">
        <div class="row mt-5 mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h4>Stock Report</h4>
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
                            <a href="{{ route('stock-reports.export', ['type' => 'xlsx']) }}" class="btn btn-secondary">
                                <i class="ri-export-fill"></i> Download Excel
                            </a>
                            <a href="{{ route('stock-reports.export', ['type' => 'csv']) }}" class="btn btn-dark">
                                <i class="ri-export-fill"></i> Download CSV
                            </a>
                        </div>
                                            
                        <div class="table-responsive">
                            <table class="table text-nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Opening Stock</th>
                                        <th>Purhcase Stock</th>
                                        <th>Sales Stock</th>
                                        <th>Closing Stock</th>
                                        <th>Re-Order Stock</th>
                                        <th>Product Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($productreport as $report)
                                            <tr>
                                                <td>{{ $report->product_name }}</td>
                                                <td>{{ $report->stock->opening_stock }}</td>
                                                <td>
                                                    <button type="button" class="badge btn-secondary " data-bs-toggle="modal" data-bs-target="#purchaseModal{{ $report->id }}">
                                                        {{ $report->purchase_count ?? 'N/A' }}
                                                    </button>
                                                    <!-- Purchase Modal -->
                                                    <div wire:ignore.self class="modal fade" id="purchaseModal{{ $report->id }}" tabindex="-1" aria-labelledby="purchaseModalLabel{{ $report->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-secondary ">
                                                                    <h5 class="text-white modal-title" id="purchaseModalLabel{{ $report->id }}">Purchase Details for {{ $report->product_name }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @if($report->purchase->isEmpty())
                                                                        <p class="text-center mb-0 text-muted">No purchases found for this product.</p>
                                                                    @else
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered table-striped table-hover">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Purchase ID</th>
                                                                                        <th>Quantity</th>
                                                                                        <th>Price</th>
                                                                                        <th>Date</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach($report->purchase as $purchase)
                                                                                        <tr>
                                                                                            <td>{{ $purchase->purchaseOrder->purchase_order_no }}</td>
                                                                                            <td>{{ $purchase->quantity }}</td>
                                                                                            <td>{{ $purchase->price }}</td>
                                                                                            <td>{{ $purchase->created_at->format('d-m-Y') }}</td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </td>
                                                <td>
                                                    <!-- Sales Button -->
                                                    <button type="button" class="badge btn-secondary" data-bs-toggle="modal" data-bs-target="#saleModal{{ $report->id }}">
                                                        {{ $report->sale_count ?? 'N/A' }}
                                                    </button>
                                                
                                                    <!-- Sales Modal -->
                                                    <div wire:ignore.self class="modal fade" id="saleModal{{ $report->id }}" tabindex="-1" aria-labelledby="saleModalLabel{{ $report->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <!-- Modal Header -->
                                                                <div class="modal-header bg-secondary ">
                                                                    <h5 class="modal-title text-white" id="saleModalLabel{{ $report->id }}">Sales Details for {{ $report->product_name }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                
                                                                <!-- Modal Body -->
                                                                <div class="modal-body">
                                                                    @if($report->sale->isEmpty())
                                                                        <p class="text-center mb-0 text-muted">No sales found for this product.</p>
                                                                    @else
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered table-striped table-hover">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Sale ID</th>
                                                                                        <th>Quantity</th>
                                                                                        <th>Price</th>
                                                                                        <th>Date</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach($report->sale as $sale)
                                                                                        <tr>
                                                                                            <td>{{ $sale->id }}</td>
                                                                                            <td>{{ $sale->quantity }}</td>
                                                                                            <td>{{ $sale->price }}</td>
                                                                                            <td>{{ $sale->created_at->format('d-m-Y') }}</td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                
                                                                <!-- Modal Footer -->
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
    
                                                
                                                <td>
                                                    @php
                                                        $closingStock = $report->stock->opening_stock + $report->purchase_count - $report->sale_count;
                                                    @endphp
                                                    {{ $closingStock ?? 'N/A' }}
                                                </td>      
                                                <td>{{ $report->stock->reorder_stock }}</td>
                                                <td>{{ $report->price }}</td>
                                                
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No Records Found</td>
                                            </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mb-3">
                                {{$productreport->links('custom-pagination-links')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
