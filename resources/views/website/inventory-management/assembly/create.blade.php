@extends('website.master')

@section('title', 'Create Assembly')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Create Assembly</h2>
            <a href="{{route('assemblies.index')}}" type="button" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('assemblies.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Assembly</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Assembly</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="container">
            <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
                <form method="POST" action="{{ route('assemblies.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="challan_no">Challan No</label>
                        <input type="text" name="challan_no" id="challan_no" class="form-control" value="{{ $purchaseOrderNo }}" readonly style="cursor:not-allowed;">
                    </div>
                    <div class="mb-3">
                        <label for="date">Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
            
                    <table class="table table-bordered" id="assemblyTable">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Branch</th>
                                <th>Godown</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="assemblyBody">
                            <tr>
                                <td>
                                    <select name="product_id[]" class="form-control" required>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="branch_id[]" class="form-control" required>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="godown_id[]" class="form-control" required>
                                        @foreach($godowns as $godown)
                                            <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="quantity[]" class="form-control" step="0.01" required></td>
                                <td><input type="number" name="price[]" class="form-control" step="0.01" required></td>
                                <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="addRow" class="btn btn-success">Add Row</button>
                    <button type="submit" class="btn btn-primary">Save Assembly</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addRowButton = document.getElementById('addRow');
        const assemblyBody = document.getElementById('assemblyBody');

        addRowButton.addEventListener('click', function() {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <select name="product_id[]" class="form-control" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="branch_id[]" class="form-control" required>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="godown_id[]" class="form-control" required>
                        @foreach($godowns as $godown)
                            <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="quantity[]" class="form-control" step="0.01" required></td>
                <td><input type="number" name="price[]" class="form-control" step="0.01" required></td>
                <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
            `;
            assemblyBody.appendChild(newRow);

            // Add event listener to the new remove button
            newRow.querySelector('.remove-row').addEventListener('click', function() {
                this.closest('tr').remove();
            });
        });

        // Remove row
        document.querySelectorAll('.remove-row').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('tr').remove();
            });
        });
    });
</script>
@endpush
@endsection
