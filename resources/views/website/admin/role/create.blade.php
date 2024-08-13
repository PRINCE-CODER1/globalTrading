@extends('website.master')

@section('title', 'Edit Roles')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5">
            <h4>
                Create Roles
            </h4>
            <a href="{{route('roles.index')}}" type="button" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('roles.index')}}"><i class="ti ti-apps me-1 fs-15"></i>Roles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Roles</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="conatiner">
            <div class="col-12  mb-5 mt-3 bg-white p-5 shadow">
                <form action="{{route('roles.store')}}" method="post" >
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
                    <div class="mb-3">
                        @if ($permissions->isNotEmpty())
                        @foreach ($permissions as $permission)
                            <input id="permission-{{$permission->id}}" type="checkbox" class="rounded" name="permission[]" value="{{$permission->name}}">
                            <label for="permission-{{$permission->id}}">{{$permission->name}}</label>
                        @endforeach   
                        @endif
                    </div>
                    <button class="btn btn-secondary" type="submit">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
