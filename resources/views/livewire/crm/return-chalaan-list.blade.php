<div class="container">
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
            <h4 class="mb-0">Return Chalaans</h4>
            <a href="{{ route('return-chalaan.create') }}" class="btn btn-secondary btn-wave float-end"><i class="ri-add-circle-line"></i> Create New Return Chalaan</a>
        </div>
        <hr>
    </div>


    <!-- Success Message -->
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <!-- Table for Listing Return Chalaans -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>Return Reference ID</th>
                                    <th>External Chalaan ID</th>
                                    <th>Returned By</th>
                                    <th>Products Returned</th>
                                    <th>Godown</th>
                                    <th>Branch</th>
                                    <th>Return Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($returnChalaans as $returnChalaan)
                                    <tr>
                                        <td>{{ $returnChalaan->return_reference_id }}</td>
                                        <td>{{ $returnChalaan->externalChalaan->reference_id }}</td>
                                        <td>{{ $returnChalaan->returnedBy->name }}</td>
                                        <td>
                                            @foreach ($returnChalaan->returnChalaanProducts as $returnProduct)
                                                <p>{{ $returnProduct->product->product_name }} (Quantity: {{ $returnProduct->quantity_returned }})</p>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($returnChalaan->returnChalaanProducts as $returnProduct)
                                                <p>{{ $returnProduct->godown->godown_name }}</p>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($returnChalaan->returnChalaanProducts as $returnProduct)
                                                <p>{{ $returnProduct->branch->name }}</p>
                                            @endforeach
                                        </td>
                                        <td>{{ $returnChalaan->created_at->format('d M Y') }}</td>
                                        <td>
                                            <!-- Actions: View, Edit, Delete -->
                                            <a href="{{ route('return-chalaan.show', $returnChalaan->id) }}" class="btn btn-info btn-sm"><i class="ri-eye-line"></i> view</a>
                                            <a href="{{ route('return-chalaan.edit', $returnChalaan->id) }}" class="btn btn-link text-info"><i class="ri-edit-line"></i></a>
                
                                            <!-- Delete button with confirmation -->
                                            <form action="{{ route('return-chalaan.destroy', $returnChalaan->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger fs-14 lh-1 p-0" onclick="return confirm('Are you sure you want to delete this return chalaan?')"><i class="ri-delete-bin-5-line"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No Return Chalaans Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $returnChalaans->links('custom-pagination-links') }}
    </div>
</div>