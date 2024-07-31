@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
            <h4>Edit Unit of Measurement</h4>
            <a href="{{ route('units.index') }}" class="btn btn-outline-secondary btn-wave float-end">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 my-5 bg-white p-5 shadow">
            <form action="{{ route('units.update', $unit->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Symbol</label>
                    <div class="input-group">
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="ri-apps-2-add-line"></i></span>
                            <input value="{{ old('symbol', $unit->symbol) }}"  name="symbol" type="text" class="form-control" placeholder="enter mobile" id="validationCustomUsername"
                                aria-describedby="inputGroupPrepend" required>
                            <div class="invalid-feedback">
                                Please fill the title.
                            </div>
                        </div>
                        @error('name')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Formula Name</label>
                    <div class="input-group">
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="ri-formula"></i></span>
                            <input value="{{ old('formula_name', $unit->formula_name) }}"  name="formula_name" type="text" class="form-control" placeholder="enter formula" id="validationCustomUsername"
                                aria-describedby="inputGroupPrepend" required>
                            <div class="invalid-feedback">
                                Please fill the title.
                            </div>
                        </div>
                        @error('formula_name')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
            
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Has Decimals?</label>
                    <div class="input-group">
                        <select name="has_decimals" id="has_decimals" class="form-control" required>
                            <option value="0" @selected(old('has_decimals', $unit->has_decimals) == 0)>No</option>
                            <option value="1" @selected(old('has_decimals', $unit->has_decimals) == 1)>Yes</option>
                        </select>
                        
                    </div>
                </div>
            
                <div class="mb-3" id="decimal-places-group" @if(old('has_decimals', $unit->has_decimals) == 0) style="display: none;" @endif>
                    <label for="decimal_places">Decimal Places</label>
                    <input type="number" name="decimal_places" id="decimal_places" class="form-control" min="0" value="{{ old('decimal_places', $unit->decimal_places) }}">
                </div>
            
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
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
@endpush
@endsection
