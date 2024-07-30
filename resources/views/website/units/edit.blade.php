@extends('website.master')

@section('content')
<div class="container">
    <h2>Edit Unit of Measurement</h2>
    <form action="{{ route('units.update', $unit->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="symbol">Symbol</label>
            <input type="text" name="symbol" class="form-control" value="{{ old('symbol', $unit->symbol) }}" required>
        </div>
    
        <div class="form-group">
            <label for="formula_name">Formula Name</label>
            <input type="text" name="formula_name" class="form-control" value="{{ old('formula_name', $unit->formula_name) }}" required>
        </div>
    
        <div class="form-group">
            <label for="has_decimals">Has Decimals?</label>
            <select name="has_decimals" id="has_decimals" class="form-control" required>
                <option value="0" @selected(old('has_decimals', $unit->has_decimals) == 0)>No</option>
                <option value="1" @selected(old('has_decimals', $unit->has_decimals) == 1)>Yes</option>
            </select>
        </div>
    
        <div class="form-group" id="decimal-places-group" @if(old('has_decimals', $unit->has_decimals) == 0) style="display: none;" @endif>
            <label for="decimal_places">Decimal Places</label>
            <input type="number" name="decimal_places" id="decimal_places" class="form-control" min="0" value="{{ old('decimal_places', $unit->decimal_places) }}">
        </div>
    
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

{{-- @section('scripts') --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hasDecimalsSelect = document.getElementById('has_decimals');
        const decimalPlacesGroup = document.getElementById('decimal-places-group');

        // Show or hide the decimal places input based on the selected value
        hasDecimalsSelect.addEventListener('change', function () {
            if (this.value == '1') {
                decimalPlacesGroup.style.display = 'block';
            } else {
                decimalPlacesGroup.style.display = 'none';
            }
        });

        // Initial display logic
        if (hasDecimalsSelect.value == '1') {
            decimalPlacesGroup.style.display = 'block';
        }
    });
</script>
{{-- @endsection --}}
@endsection
