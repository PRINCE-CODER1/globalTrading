@extends('website.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-5">
            <a href="{{route('articles.index')}}" class="btn btn-success btn-wave float-end">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 col-md-6 mt-5 bg-white p-5 shadow">
            <form action="{{route('articles.update',$articles->id)}}" method="POST">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Enter name</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-user-line"></i></div>
                        <input value="{{old('title',$articles->title)}}" name="title" type="text" class="form-control" id="form-text1" placeholder="enter name">
                        @error('name')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Author</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-user-line"></i></div>
                        <input value="{{old('author',$articles->author)}}" name="author" type="text" class="form-control" id="form-text1" placeholder="enter name">
                        @error('author')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Author</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="ri-user-line"></i></div>
                        <input value="{{old('text',$articles->text)}}" name="text" type="text" class="form-control" id="form-text1" placeholder="enter name">
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="mb-3">
                        <button class="btn btn-dark">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
