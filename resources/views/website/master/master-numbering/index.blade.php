@extends('website.master')

@section('content')
<div class="container my-5">
    <!-- Title Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center mb-2">
            <h2 class="text-dark fw-bold">Master Numbering Data</h2>
        </div>
    </div>

    <!-- Breadcrumb Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master_numbering.index') }}"><i class="ti ti-apps me-1 fs-15"></i>Format Numbering</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Numbering</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Container -->
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-12">
            <div class="card border-light shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Create or Update Numbering Formats</h5>
                </div>
                <div class="card-body">
                    <!-- Display Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Display Validation Errors -->
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('master_numbering.store') }}" method="POST" id="numbering-form">
                        @csrf

                        <!-- Select Financial Year -->
                        <div class="mb-4">
                            <label for="financial_year" class="form-label fw-semibold text-secondary">Select Financial Year:</label>
                            <select name="financial_year" id="financial_year" class="form-select shadow-sm" required>
                                @foreach($financialYears as $financialYear)
                                    <option value="{{ $financialYear }}" {{ old('financial_year', isset($masterNumbering) ? $masterNumbering->financial_year : '') == $financialYear ? 'selected' : '' }}>
                                        {{ $financialYear }}
                                    </option>
                                @endforeach
                            </select>
                            @error('financial_year')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fields for Each Type -->
                        @foreach([
                            'sale_order' => 'Sale Order',
                            'purchase_order' => 'Purchase Order',
                            'in_transit_order' => 'In Transit Order',
                            'challan' => 'Challan',
                            'sale' => 'Sale',
                            'purchase' => 'Purchase',
                            'stock_transfer' => 'Stock Transfer',
                            'branch_to_workshop_transfer' => 'Branch to Workshop Transfer',
                            'workshop_to_branch_transfer' => 'Workshop to Branch Transfer',
                            'branch_to_customer_transfer' => 'Branch to Customer Transfer',
                            'customer_to_branch_transfer' => 'Customer to Branch Transfer'
                        ] as $type => $label)
                        <div class="mb-4">
                            <h5 class="fs-6 mb-3 text-dark">{{ $label }}</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="{{ $type }}_prefix" class="form-label">Prefix:</label>
                                    <input type="text" id="{{ $type }}_prefix" name="{{ $type }}_prefix" class="form-control shadow-sm" placeholder="Prefix" value="{{ old("{$type}_prefix", isset($masterNumbering) ? $masterNumbering->{$type . '_prefix'} : '') }}" required>
                                    @error("{{ $type }}_prefix")
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="{{ $type }}_number" class="form-label">Number:</label>
                                    <input type="number" id="{{ $type }}_number" name="{{ $type }}_number" class="form-control shadow-sm" placeholder="Number" value="{{ old("{$type}_number", isset($masterNumbering) ? $masterNumbering->{$type . '_number'} : '') }}" required>
                                    @error("{{ $type }}_number")
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="{{ $type }}_suffix" class="form-label">Suffix:</label>
                                    <input type="text" id="{{ $type }}_suffix" name="{{ $type }}_suffix" class="form-control shadow-sm" placeholder="Suffix" value="{{ old("{$type}_suffix", isset($masterNumbering) ? $masterNumbering->{$type . '_suffix'} : '') }}" required>
                                    @error("{{ $type }}_suffix")
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-secondary">
                                <i class="bi bi-save me-1"></i> save master numbering
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Save and Restore Old Values -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Retrieve and set saved values
        const form = document.getElementById('numbering-form');
        const fields = form.querySelectorAll('input, select');

        fields.forEach(field => {
            const savedValue = localStorage.getItem(field.name);
            if (savedValue) {
                field.value = savedValue;
            }

            // Save values on change
            field.addEventListener('change', function () {
                localStorage.setItem(field.name, field.value);
            });
        });
    });
</script>

@endsection
