<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contractor;

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ContractorController extends Controller implements HasMiddleware
{
    public static function middleware(): array{
        return [
            new Middleware('permission:view contract', only: ['index']),
            new Middleware('permission:edit contract', only: ['edit']),
            new Middleware('permission:create contract', only: ['create']),
            new Middleware('permission:delete contract', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('website.master.contractors.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.master.contractors.create');
    }

    public function edit($id)
    {
        $lead = Contractor::findOrFail($id);
        return view('website.master.contractors.edit',compact('lead'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'contractor_type' => 'nullable|string|max:100',
            'user_id' => 'required|exists:users,id',
        ]);

        Contractor::create($request->all());

        toastr()->closeButton()->success('contractor created successfully.');
        return redirect()->route('contractor.index');
    }
    // Update the specified lead type in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'contractor_type' => 'nullable|string|max:100',
            'user_id' => 'required|exists:users,id',
        ]);

        $lead = Contractor::findOrFail($id);
        $lead->update($request->all());
        toastr()->closeButton()->success('contractor updated successfully.');

        return redirect()->route('contractor.index');
    }
}
