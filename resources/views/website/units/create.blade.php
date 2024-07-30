@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
        <h4>Create Unit of Measurement</h4>
        <a href="{{route('units.index')}}" class="btn btn-outline-secondary btn-wave float-end">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-6 mt-5 bg-white p-5 shadow">
            <form action="{{ route('units.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Symbol</label>
                    <div class="input-group">
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input  name="symbol" type="text" class="form-control" placeholder="Eg-Kg,Gr" id="validationCustomUsername"
                                aria-describedby="inputGroupPrepend" required>
                            <div class="invalid-feedback">
                                Please fill the title.
                            </div>
                        </div>
                        @error('title')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Formula Name</label>
                    <div class="input-group">
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input  name="formula_name" type="text" class="form-control" placeholder="Formula Name" id="validationCustomUsername"
                                aria-describedby="inputGroupPrepend" required>
                            <div class="invalid-feedback">
                                Please fill the title.
                            </div>
                        </div>
                        @error('title')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="has_decimals"> Decimal places ?</label>
                    <label for="has_decimals" class="switch">
                        <input type="checkbox" id="has_decimals" name="has_decimals" value="1" {{ old('has_decimals') ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="my-3" id="decimal_places_input" style="display: none;">
                    <label for="form-text1" class="form-label fs-14 text-dark">Number of Decimal Places</label>
                    <div class="input-group">
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="number" class="form-control" id="decimal_places" name="decimal_places" min="0" max="10" value="{{ old('decimal_places', 2) }}">

                        </div>
                        
                    </div>
                </div>
                <div class="col-12">
                    <div class="my-3">
                        <button type="submit" class="btn btn-dark">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hasDecimalsCheckbox = document.getElementById('has_decimals');
        const decimalPlacesInput = document.getElementById('decimal_places_input');

        function toggleDecimalPlacesInput() {
            if (hasDecimalsCheckbox.checked) {
                decimalPlacesInput.style.display = 'block';
            } else {
                decimalPlacesInput.style.display = 'none';
            }
        }

        hasDecimalsCheckbox.addEventListener('change', toggleDecimalPlacesInput);

        // Initialize the state based on the current value
        toggleDecimalPlacesInput();
    });
</script>
</div>
@endsection
