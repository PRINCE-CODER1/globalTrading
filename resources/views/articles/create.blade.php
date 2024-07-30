{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    form
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
@extends('website.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Create Article</h4>
            <a href="{{route('articles.index')}}"  class="btn btn-success btn-wave float-end">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-6 mt-5 bg-white p-5 shadow">
            <form action="{{route('articles.store')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Title</label>
                    <div class="input-group">
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input value="{{old('title')}}" name="title" type="text" class="form-control" placeholder="title" id="validationCustomUsername"
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
                    <label for="form-text1" class="form-label fs-14 text-dark">Author</label>
                    <div class="input-group">
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="ri-user-line"></i></span>
                            <input value="{{old('author')}}" name="author" type="text" class="form-control" placeholder="author" id="validationCustomUsername"
                                aria-describedby="inputGroupPrepend" required>
                            <div class="invalid-feedback">
                                Please fill the Author Option.
                            </div>
                        </div>
                            @error('author')
                                <p class="text-danger">{{$message}}</p>
                            @enderror                    
                        </div>
                </div>
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Content</label>
                    <div class="form-floating mb-4">
                        <textarea name="text" class="form-control" placeholder="Leave a comment here"
                            id="floatingTextarea">{{old('text')}}</textarea>
                        <label for="floatingTextarea">Description</label>
                    </div>
                </div>
                
                
                <div class="col-12">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-dark">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
