@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h2 class="mb-0">Edit Visit</h2>
            <a href="{{ route('visits.index') }}" type="button" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('visits.index') }}"><i class="ti ti-apps me-1 fs-15"></i>Visits</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Visit</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="container">
            <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
                <form action="{{ route('visits.update', $visit->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="visitor_name" class="form-label fs-14 text-dark">Visitor Name :</label>
                        <input type="text" name="visitor_name" id="visitor_name" class="form-control" value="{{ $visit->visitor_name }}" required>
                    </div>
                    <div class="mb-3">
                        <input type="hidden" name="created_by" id="created_by" class="form-control" value="{{ $visit->created_by }}" readonly>
                    </div>
                    <button type="submit" class="btn btn-secondary mt-3">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
