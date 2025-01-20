@extends('website.master')

@section('title', 'Edit User')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-between mt-5 ">
            <h4 class="mb-0">
                Edit User
            </h4>
            @if(Auth::user()->hasRole('Admin')) 
            <a href="{{route('users.index')}}" type="button" class="btn btn-secondary">Back</a>
            @endif
        </div>
    </div>
</div>
@if(Auth::user()->hasRole('Admin')) 
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><i class="ti ti-home-2 me-1 fs-15"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{route('users.index')}}"><i class="ti ti-apps me-1 fs-15"></i>User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
@endif
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form method="POST" action="{{ route('users.update', $users->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">User Name</label>
                    <div class="input-group">
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="ri-user-line"></i></span>
                            <input value="{{ old('name', $users->name) }}"  name="name" type="text" class="form-control" placeholder="enter email" id="validationCustomUsername"
                                aria-describedby="inputGroupPrepend" required>
                            <div class="invalid-feedback">
                                Please fill the title.
                            </div>
                        </div>
                        @error('name')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Email</label>
                    <div class="input-group">
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="ri-user-line"></i></span>
                            <input value="{{ old('email', $users->email) }}"  name="email" type="email" class="form-control" placeholder="enter email" id="validationCustomUsername"
                                aria-describedby="inputGroupPrepend" required>
                            <div class="invalid-feedback">
                                Please fill the title.
                            </div>
                        </div>
                        @error('name')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="form-text1" class="form-label fs-14 text-dark">Password</label>
                    <div class="input-group">
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="ri-user-line"></i></span>
                            <input name="password" type="password" class="form-control" placeholder="password" id="validationCustomUsername"
                                aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fs-14 text-dark" for="permissions">Roles</label>
                    @if(Auth::user()->hasRole('Admin'))  <!-- Check if the logged-in user is an admin -->
                        @foreach($roles as $role)
                            <div class="mb-3">
                                <label for="role-{{ $role->id }}">{{ $role->name }}</label>
                                <label class="switch">
                                    <input type="checkbox" 
                                           {{ $hasRoles->contains($role->id) ? 'checked' : '' }} 
                                           id="role-{{ $role->id }}" 
                                           name="role[]" 
                                           class="role-checkbox" 
                                           value="{{ $role->id }}">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        @endforeach
                    @else
                        <p>You do not have permission to view roles.</p> <!-- Optional: Message for non-admin users -->
                    @endif
                </div>
                
                

                <button type="submit" class="btn btn-secondary">Update</button>
                
            </form>
        </div>
    </div>
</div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Get all role checkboxes
            const roleCheckboxes = document.querySelectorAll('.role-checkbox');
            
            roleCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Uncheck all checkboxes except the one that was clicked
                    roleCheckboxes.forEach(cb => {
                        if (cb !== this) {
                            cb.checked = false;
                        }
                    });
                });
            });
        });
        </script>
        
    @endpush
</div>
@endsection
