@extends('website.master')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-2">
            <h4 class="mb-0 d-flex justify-content-between align-items-center">Create Unit of Measurement</h4>
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
                    <li class="breadcrumb-item active" aria-current="page">Create Unit</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('units.store') }}" method="POST">
                @csrf

                <!-- Symbol Field -->
                <div class="mb-3">
                    <label for="symbol" class="form-label fs-14 text-dark">Symbol</label>
                    <div class="input-group">
                        <span class="input-group-text" id="symbolAddon"><i class="ri-apps-2-add-line"></i></span>
                        <input name="symbol" type="text" class="form-control" id="symbol" placeholder="Eg-Kg,Gr" aria-describedby="symbolAddon" required>
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
                        <input name="formula_name" type="text" class="form-control" id="formula_name" placeholder="Formula Name" aria-describedby="formulaNameAddon" required>
                        @error('formula_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Decimal Places Toggle -->
                <div class="mb-3">
                    <label for="has_decimals" class="form-label fs-14 text-dark">Decimal Places?</label>
                    <label class="switch">
                        <input type="checkbox" id="has_decimals" name="has_decimals" value="1" {{ old('has_decimals') ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>

                <!-- Number of Decimal Places -->
                <div class="mb-3" id="decimal_places_input" style="display: none;">
                    <label for="decimal_places" class="form-label fs-14 text-dark">Number of Decimal Places</label>
                    <div class="input-group">
                        <span class="input-group-text" id="decimalPlacesAddon">@</span>
                        <input type="number" class="form-control" id="decimal_places" name="decimal_places" min="0" max="10" value="{{ old('decimal_places', 2) }}">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="my-3">
                    <button type="submit" class="btn btn-secondary mt-3">
                        <i class="bi bi-check2 me-1"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for Toggle Visibility -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hasDecimalsCheckbox = document.getElementById('has_decimals');
        const decimalPlacesInput = document.getElementById('decimal_places_input');

        function toggleDecimalPlacesInput() {
            decimalPlacesInput.style.display = hasDecimalsCheckbox.checked ? 'block' : 'none';
        }

        hasDecimalsCheckbox.addEventListener('change', toggleDecimalPlacesInput);
        toggleDecimalPlacesInput(); // Initialize the state based on the current checkbox value
    });
</script>
@endsection
