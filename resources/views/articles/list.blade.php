@extends('website.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
            <h4 class="mb-0">Articles</h4>
            <a href="{{route('articles.create')}}" class="btn btn-success btn-wave float-end">Create</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mt-2">
            
            @livewire('articles')
        </div>
    </div>
</div>
@endsection