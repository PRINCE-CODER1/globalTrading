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
        $permissions = Permission::orderBy('created_at','ASC')->paginate(10);
        return view('website.permissions.list',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=> 'required|unique:permissions|min:3'
        ]);
        if($validator->passes()){
            Permission::create([
                'name' => $request->name
            ]);
            toastr()->closeButton(true)->success('Permission Added Successfully');
            return redirect()->route('permissions.index');
        }
        else{
            toastr()->closeButton(true)->error('sorry');
            return redirect()->route('permissions.create');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permissions = Permission::findOrFail($id);
        return view('website.permissions.edit',compact('permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permissions = Permission::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'name'=> 'required|min:3|unique:permissions,name,'.$id.',id',
        ]);
        if($validator->passes()){
            $permissions->name = $request->name;
            $permissions->save();
            toastr()->closeButton(true)->success('Permission Updated Successfully');
            return redirect()->route('permissions.index');
        }else{
            toastr()->closeButton(true)->error('sorry name is too short');
            return redirect()->route('permissions.edit',$id);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
