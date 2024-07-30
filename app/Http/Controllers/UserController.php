<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
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
            'password' => 'nullable|min:8', // Ensure password confirmation
            'role' => 'nullable|array', // Ensure roles are provided as an array
            'role.*' => 'exists:roles,id' // Ensure each role ID exists
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
            'password' => Hash::make($request->password), // Hash the password
        ]);

        // Assign roles to the user
        if ($request->has('role')) {
            $roles = Role::whereIn('id', $request->role)->pluck('name')->toArray();
            $user->syncRoles($roles);
        }

        toastr()->closeButton(true)->success('User created successfully.');
        return redirect()->route('users.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('website.admin.user.list');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::findOrFail($id);
        $roles = Role::orderBy('name','ASC')->get();
        $hasRoles = $users->roles->pluck('id');
        return view('website.admin.user.edit',compact('users','roles','hasRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:users,name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed', // Ensure password confirmation
            'role' => 'nullable|array', // Ensure roles are provided as an array
            'role.*' => 'exists:roles,id' // Ensure each role ID exists
        ]);

        if ($validator->fails()) {
            toastr()->closeButton(true)->error('User not updated.');
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

        $user->save();

        // Assign roles to the user
        if ($request->has('role')) {
            $roles = Role::whereIn('id', $request->role)->pluck('name')->toArray();
            $user->syncRoles($roles);
        } else {
            $user->syncRoles([]);
        }

        toastr()->closeButton(true)->success('User updated successfully.');
        return redirect()->route('users.index');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
