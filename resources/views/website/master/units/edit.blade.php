@extends('website.master')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between">
            <h4>Edit Unit of Measurement</h4>
            <a href="{{ route('units.index') }}" class="btn btn-outline-secondary btn-wave float-end">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <!-- Breadcrumb Navigation -->
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('units.index') }}"><i class="ti ti-apps me-1 fs-15"></i>Units</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Unit</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('units.update', $unit->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Symbol Field -->
                <div class="mb-3">
                    <label for="symbol" class="form-label fs-14 text-dark">Symbol</label>
                    <div class="input-group">
                        <span class="input-group-text" id="symbolAddon"><i class="ri-apps-2-add-line"></i></span>
                        <input value="{{ old('symbol', $unit->symbol) }}" name="symbol" type="text" class="form-control" id="symbol" placeholder="Enter Symbol" aria-describedby="symbolAddon" required>
                        @error('symbol')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Formula Name Field -->
                <div class="mb-3">
                    <label for="formula_name" class="form-label fs-14 text-dark">Formula Name</label>
                    <div class="input-group">
                        <span class="input-group-text" id="formulaNameAddon"><i class="ri-formula"></i></span>
                        <input value="{{ old('formula_name', $unit->formula_name) }}" name="formula_name" type="text" class="form-control" id="formula_name" placeholder="Enter Formula Name" aria-describedby="formulaNameAddon" required>
                        @error('formula_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Has Decimals Select -->
                <div class="mb-3">
                    <label for="has_decimals" class="form-label fs-14 text-dark">Has Decimals?</label>
                    <select name="has_decimals" id="has_decimals" class="form-control" required>
                        <option value="0" {{ old('has_decimals', $unit->has_decimals) == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('has_decimals', $unit->has_decimals) == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <!-- Decimal Places Input -->
                <div class="mb-3" id="decimal-places-group" style="{{ old('has_decimals', $unit->has_decimals) == 1 ? 'display: block;' : 'display: none;' }}">
                    <label for="decimal_places">Decimal Places</label>
                    <input type="number" name="decimal_places" id="decimal_places" class="form-control" min="0" value="{{ old('decimal_places', $unit->decimal_places) }}">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-secondary mt-3">
                    <i class="bi bi-pencil-square me-1"></i> Update
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hasDecimalsSelect = document.getElementById('has_decimals');
        const decimalPlacesGroup = document.getElementById('decimal-places-group');

        function toggleDecimalPlacesGroup() {
            if (hasDecimalsSelect.value == '1') {
                decimalPlacesGroup.style.display = 'block';
            } else {
                decimalPlacesGroup.style.display = 'none';
            }
        }

        hasDecimalsSelect.addEventListener('change', toggleDecimalPlacesGroup);
        toggleDecimalPlacesGroup(); // Initialize display based on current value
    });
</script>
@endpush
@endsection
