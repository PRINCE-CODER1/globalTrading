@extends('website.master')

@section('title', 'Create Assembly')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Create Assembly</h2>
            <a href="{{ route('assemblies.index') }}" type="button" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('assemblies.index') }}"><i class="ti ti-apps me-1 fs-15"></i>Assembly</a></li>
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
                        <input type="text" name="challan_no" id="challan_no" class="form-control" value="{{ old('challan_no', $purchaseOrderNo) }}" readonly style="cursor:not-allowed;">
                    </div>
                    <div class="mb-3">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>
            
                    <table class="table table-bordered nowrap mb-3" id="assemblyTable">
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
                                    <select name="product_id[]"  class="form-select" required>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="branch_id[]"  class="form-select" required>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="godown_id[]"  class="form-select" required>
                                        @foreach($godowns as $godown)
                                            <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="quantity[]" class="form-control" step="0.01" required></td>
                                <td><input type="number" name="price[]" class="form-control" step="0.01" required></td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <span class="me-1">Remove</span>
                                        <button type="button" class="btn btn-icon btn-danger-light rounded-pill btn-wave  "><i class="remove-row ri-close-circle-fill"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <span class="me-1">Add</span>
                        <button type="button" id="addRow" class="btn btn-icon btn-secondary-light rounded-pill btn-wave"><i class=" ri-add-circle-fill"></i></button>
                    </div>
                    <button type="submit" class="btn btn-secondary float-end">Save Assembly</button>
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
                <td><button type="button" class="btn btn-icon btn-danger-light rounded-pill btn-wave mt-3 "><i class="remove-row ri-close-circle-fill"></i></button></td>
            `;
            assemblyBody.appendChild(newRow);
        });

        // Delegate event listener for removing rows
        assemblyBody.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-row')) {
                event.target.closest('tr').remove();
            }
        });
    });
</script>
@endpush
@endsection
