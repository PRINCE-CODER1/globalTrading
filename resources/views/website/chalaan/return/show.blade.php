@extends('website.master')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h4>Return Chalaan Details</h4>
            <hr>
        </div>
        
        <!-- Return Chalaan Information -->
        <div class="col-md-6">
            <h6>Return Reference ID:</h6>
            <p>{{ $returnChalaan->return_reference_id }}</p>

            <h6>External Chalaan ID:</h6>
            <p>{{ $returnChalaan->externalChalaan->reference_id }}</p>

            <h6>Returned By:</h6>
            <p>{{ $returnChalaan->returnedBy->name }}</p>

            <h6>Return Date:</h6>
            <p>{{ $returnChalaan->created_at->format('d M Y') }}</p>
        </div>

        <!-- Products Returned -->
        <div class="col-md-6">
            <h6>Products Returned:</h6>
            @foreach ($returnChalaan->returnChalaanProducts as $returnProduct)
                <p>
                    <strong>{{ $returnProduct->product->product_name }}</strong> 
                    (Quantity: {{ $returnProduct->quantity_returned }})
                    <br> Godown: {{ $returnProduct->godown->godown_name }}
                    <br> Branch: {{ $returnProduct->branch->name }}
                </p>
            @endforeach
        </div>
        
        <!-- Back Button -->
        <div class="col-12 mt-3">
            <a href="{{ route('return-chalaan.index') }}" class="btn btn-primary">Back to Return Chalaan List</a>
        </div>
    </div>
</div>
@endsection