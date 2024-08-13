@extends('website.master')

@section('title', 'Edit Roles')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 ">
            <h4 class="mb-0">
                Edit Roles
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
                    <li class="breadcrumb-item active" aria-current="page">Edit Roles</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="container">
            <div class="col-12 mt-3 mb-5 bg-white p-5 shadow">
                <form method="POST" action="{{ route('roles.update', $role->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="form-text1" class="form-label fs-14 text-dark">Name</label>
                        <div class="input-group">
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend"><i class="ri-user-line"></i></span>
                                <input value="{{ old('name', $role->name) }}"  name="name" type="text" class="form-control" placeholder="enter category" id="validationCustomUsername"
                                    aria-describedby="inputGroupPrepend" >
                                <div class="invalid-feedback">
                                    Please fill the title.
                                </div>
                            </div>
                            @error('name')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row border rounded py-4 mb-3">
                        @foreach($permissionGroups as $category => $permissions)
                            <div class="col-12 mb-3">
                                <p class="mb-0 d-inline-block px-3 py-1 rounded text-white bg-primary">{{ ucfirst($category) ?: 'General Permissions' }}</p>
                            </div>
                            @foreach($permissions as $permission)
                                <div class="col-md-4">
                                    <div class="mb-3 d-flex align-items-center">
                                        <label for="permission-{{ $permission->id }}" class="me-3">
                                            <p class="mb-0">{{ $permission->name }}</p>
                                        </label>
                                        <label class="switch">
                                            <input class="form-check-input" type="checkbox" id="permission-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}"
                                                {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                    
                    {{-- <div class="mb-3">
                        <label for="permissions" class="form-label">Assign Permissions</label>
                        <div class="row">
                            @foreach($permissionGroups as $categoryName => $permissions)
                                <div class="col-12 my-3">
                                    <h5 class="mb-0 text-primary">{{ $categoryName }}</h5>
                                </div>
                                @foreach($permissions as $permission)
                                    <div class="col-md-4">
                                        <div class="my-2 d-flex align-items-center">
                                            <label for="permission-{{ $permission->id }}" class="me-3">
                                                <p class="mb-0">{{ $permission->name }}</p>
                                            </label>
                                            <label class="switch">
                                                <input class="form-check-input" type="checkbox" id="permission-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}"
                                                    {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                        
                    </div> --}}
                    
                    <button type="submit" class="btn btn-secondary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
