<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
// use Illuminate\Routing\Controllers\Middleware;
// use Illuminate\Routing\Controllers\HasMiddleware;

class RoleController extends Controller 
{
    // public static function middleware(): array{
    //     return [
    //         new Middleware('permission:view roles', only: ['index']),
    //         new Middleware('permission:edit roles', only: ['edit']),
    //         new Middleware('permission:create roles', only: ['create']),
    //         new Middleware('permission:delete roles', only: ['destroy']),
    //     ];
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('website.admin.role.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('website.admin.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3',
            'permission' => 'array'
        ]);

        if ($validator->fails()) {
            toastr()->closeButton(true)->error('Validation errors occurred');
            return redirect()->route('roles.create')
                             ->withErrors($validator)
                             ->withInput();
        }

        $role = Role::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        if (!empty($request->permission)) {
            $role->givePermissionTo($request->permission);
        }

        toastr()->closeButton(true)->success('Role added successfully');
        return redirect()->route('roles.index');
    }
    
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'ASC')->get();
        $permissionGroups = $permissions->groupBy('category');
        return view('website.admin.role.edit', compact('role', 'hasPermissions', 'permissions', 'permissionGroups'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:roles,name,' . $id,
            'permissions' => 'nullable|array', // Assuming 'permissions' contains permission IDs
        ]);

        if ($validator->fails()) {
            toastr()->closeButton(true)->error('Role not updated.');
            return redirect()->route('roles.edit', $id);
        }

        // Update role details
        $role->name = $request->name;
        $role->save();

        // Sync permissions
        if ($request->has('permissions')) {
            // Convert permission IDs to permission names
            $permissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]); // Clear all permissions if none are provided
        }

        toastr()->closeButton(true)->success('Role updated successfully.');
        return redirect()->route('roles.index', $id);
    }
}
