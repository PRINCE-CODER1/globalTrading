@extends('website.master')

@section('content')
<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 d-flex align-items-center justify-content-between ">
            <h4>Create Workshop</h4>
            <a href="{{route('workshops.index')}}" class="btn btn-outline-secondary btn-wave float-end">Back</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('workshops.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Workshop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Workshop</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="container">
                <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
                    <form action="{{ route('workshops.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="form-text1" class="form-label fs-14 text-dark">Workshop Name</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="ri-user-line"></i></div>
                                <input value="{{old('name')}}" type="text" name="name" class="form-control" id="form-text1" placeholder="">
                                @error('name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="form-text1" class="form-label fs-14 text-dark">Branch</label>
                            <div class="input-group">
                                <select class="form-control" id="branch_id" name="branch_id" required>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            
                        </div>
                        <button type="submit" class="btn btn-secondary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        
    </div>
</div>
@endsection
