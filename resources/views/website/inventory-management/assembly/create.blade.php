@extends('website.master')

@section('title', 'Create Assembly')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center mb-2">
            <h2 class="mb-0 d-flex justify-content-between align-items-center">Create Assembly</h2>
            <a href="{{ route('assemblies.index') }}" class="btn btn-outline-secondary"><i class="bi bi-chevron-left me-1"></i> Back</a>
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('assemblies.index') }}"><i class="ti ti-apps me-1 fs-15"></i>Assembly</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Assembly</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0">Assembly Details</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('assemblies.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="challan_no" class="form-label">Challan No</label>
                                <input type="text" name="challan_no" id="challan_no" class="form-control" value="{{ old('challan_no', $challanNo) }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" id="date" class="form-control" required>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="assemblyTable">
                                <thead class="table-secondary">
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
                                            <select name="product_id[]" class="form-select" required>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="branch_id[]" class="form-select" required>
                                                @foreach($branches as $branch)
                                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="godown_id[]" class="form-select" required>
                                                @foreach($godowns as $godown)
                                                    <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="quantity[]" class="form-control" step="0.01" required>
                                        </td>
                                        <td>
                                            <input type="number" name="price[]" class="form-control" step="0.01" required>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger remove-row"><i class="ri-close-circle-fill"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mb-3 mt-1">
                            <button type="button" id="addRow" class="btn btn-sm btn-secondary"><i class="ri-add-circle-fill me-1"></i>Add Row</button>
                        </div>

                        <button type="submit" class="btn btn-secondary float-end">
                            <i class="bi bi-save me-1"></i> Save Assembly
                        </button>
                    </form>
                </div>
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
                    <select name="product_id[]" class="form-select" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="branch_id[]" class="form-select" required>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="godown_id[]" class="form-select" required>
                        @foreach($godowns as $godown)
                            <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="quantity[]" class="form-control" step="0.01" required>
                </td>
                <td>
                    <input type="number" name="price[]" class="form-control" step="0.01" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger remove-row"><i class="ri-close-circle-fill"></i></button>
                </td>
            `;
            assemblyBody.appendChild(newRow);
        });

        assemblyBody.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-row') || event.target.closest('.remove-row')) {
                event.target.closest('tr').remove();
            }
        });
    });
</script>
@endpush

@endsection
