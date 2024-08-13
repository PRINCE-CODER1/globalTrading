@extends('website.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Select Financial Year</h2>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('master_numbering.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Format Numbering</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Numbering</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container  mb-5">

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 my-5 bg-white p-5 shadow">
                <form action="{{ route('master_numbering.store') }}" method="POST">
                    @csrf
                    <!-- Select Financial Year -->
                    <div class="mb-4">
                        <label for="financial_year">Select Financial Year:</label>
                        <select name="financial_year" id="financial_year" class="form-control" required>
                            @foreach($financialYears as $financialYear)
                                <option value="{{ $financialYear }}" {{ old('financial_year') == $financialYear ? 'selected' : '' }}>
                                    {{ $financialYear }}
                                </option>
                            @endforeach
                        </select>
                        @error('financial_year')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                
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
                        <h4 class="fs-18 text-dark">{{ $label }} <span><sup class="text-danger">*</sup></span></h4>
                        <div class="d-flex">
                            <div class="col-md-4 mb-3 pe-3">
                                <input type="text" placeholder="Prefix" name="{{ $type }}_prefix" class="form-control" value="{{ old($type . '_prefix') }}" required>
                                @error("{{ $type }}_prefix")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3 pe-3">
                                <input type="number" placeholder="Number" name="{{ $type }}_number" class="form-control" value="{{ old($type . '_number') }}" required>
                                @error("{{ $type }}_number")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" placeholder="Suffix" name="{{ $type }}_suffix" class="form-control" value="{{ old($type . '_suffix') }}" required>
                                @error("{{ $type }}_suffix")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endforeach
                
                    <button type="submit" class="btn btn-secondary mt-3">Submit</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endsection
