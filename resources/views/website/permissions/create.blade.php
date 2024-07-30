@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 mb-3">
            <h4>
                Create Permission
            </h4>
            <a href="{{route('permissions.index')}}" type="button" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <form action="{{route('permissions.store')}}" method="post" >
            @csrf
            <div class="col-12">
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Enter name</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-user-line"></i></div>
                        <input value="{{old('name')}}" type="text" name="name" class="form-control" id="form-text1" placeholder="">
                        @error('name')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
