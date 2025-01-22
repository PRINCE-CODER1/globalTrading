<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array{
        return [
            new Middleware('permission:view permissions', only: ['index']),
            new Middleware('permission:edit permissions', only: ['edit']),
            new Middleware('permission:create permissions', only: ['create']),
            new Middleware('permission:delete permissions', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('website.admin.permissions.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
            'category' => 'nullable|string|max:255',
        ]);

        if ($validator->passes()) {
            Permission::create([
                'name' => $request->name,
                'category' => $request->input('category'),
            ]);
            toastr()->closeButton(true)->success('Permission Added Successfully');
            return redirect()->route('permissions.index');
        } else {
            toastr()->closeButton(true)->error('Validation error.');
            return redirect()->route('permissions.create')->withErrors($validator)->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permissions = Permission::findOrFail($id);
        // Get unique categories from the permissions, filter out empty values
        $categories = $permissions->pluck('category')->unique()->filter()->values();
        return view('website.admin.permissions.edit', compact('permissions','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permissions = Permission::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,' . $id . ',id',
            'category' => 'nullable|string|max:255',
        ]);

        if ($validator->passes()) {
            $permissions->name = $request->name;
            $permissions->category = $request->input('category');
            $permissions->save();
            toastr()->closeButton(true)->success('Permission Updated Successfully');
            return redirect()->route('permissions.index');
        } else {
            toastr()->closeButton(true)->error('Validation error.');
            return redirect()->route('permissions.edit', $id)->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        toastr()->closeButton(true)->success('Permission Deleted Successfully');
        return redirect()->route('permissions.index');
    }
}
