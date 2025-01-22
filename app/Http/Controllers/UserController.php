<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array{
        return [
            new Middleware('permission:view user', only: ['index']),
            new Middleware('permission:edit user', only: ['edit']),
            new Middleware('permission:create user', only: ['create']),
            new Middleware('permission:delete user', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('website.admin.user.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('website.admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'name' => 'required|min:3|unique:users,name',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',  // Password must be confirmed
        'role' => 'nullable|exists:roles,id' // Ensure role ID exists
    ]);

    if ($validator->fails()) {
        toastr()->closeButton(true)->error('User not created.');
        return redirect()->route('users.create')
                         ->withErrors($validator)
                         ->withInput();
    }

    // Create a new user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role ? Role::find($request->role)->pluck('name')->first() : 'user',  // Default role
    ]);

    // Assign role to the user
    if ($request->has('role')) {
        $role = Role::find($request->role);
        if ($role) {
            $user->assignRole($role);
        }
    }

    toastr()->closeButton(true)->success('User created successfully.');
    return redirect()->route('users.index');
}





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        
        // Get roles and filter out based on priority
        $roles = $user->roles->pluck('name');
        $displayRoles = $roles->contains('Super Admin') ? ['Super Admin'] : $roles->toArray();

        return view('website.admin.user.list', compact('user', 'displayRoles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    // Find the user by their ID
    $users = User::findOrFail($id);

    // Check if the logged-in user is trying to edit their own profile or if the user is an admin
    if (Auth::id() !== (int) $id && !Auth::user()->hasRole('Admin')) {
        toastr()->closeButton(true)->error('You are not authorized to edit this user.');
        return redirect()->back();  // Redirect to the user list or a different page
    }

    // Get roles for the select options
    $roles = Role::orderBy('name', 'ASC')->get();

    // Get roles assigned to the user
    $hasRoles = $users->roles->pluck('id');

    // Return the edit view with the user data, roles, and assigned roles
    return view('website.admin.user.edit', compact('users', 'roles', 'hasRoles'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $user = User::findOrFail($id);

    // Only allow the user to update their own profile or an admin to update any profile
    if (Auth::id() !== (int) $id && !Auth::user()->hasRole('Admin')) {
        toastr()->closeButton(true)->error('You are not authorized to update this user.');
        return redirect()->route('users.index');  // Redirect to the user list or a different page
    }

    // Validate the request
    $validator = Validator::make($request->all(), [
        'name' => 'required|min:3|unique:users,name,' . $id,
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|min:6',
        'role' => 'nullable|exists:roles,id'  // Role validation if provided
    ]);

    // Check for validation errors
    if ($validator->fails()) {
        toastr()->closeButton(true)->error('User not updated. Please check your input.');
        return redirect()->route('users.edit', $id)
                         ->withErrors($validator)
                         ->withInput();
    }

    // Update user details
    $user->name = $request->name;
    $user->email = $request->email;

    // Update password if provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // Only update the role if the current user is an admin
    if (Auth::user()->hasRole('admin')) {
        if ($request->has('role')) {
            $role = Role::find($request->role);
            if ($role) {
                $user->syncRoles($role);  // Assign the new role
            }
        } else {
            $user->syncRoles([]);  // Remove roles if no role is provided
        }
    }

    // Save the user
    $user->save();

    toastr()->closeButton(true)->success('User updated successfully.');
    return redirect()->back();
}

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
