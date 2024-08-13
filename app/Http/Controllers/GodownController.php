<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Branch;
use App\Models\Godown;

class GodownController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('website.master.godowns.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $branches = Branch::all();
        return view('website.master.godowns.create',compact('users', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'godown_name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'mobile' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        Godown::create(array_merge($request->all(), [
            'user_id' => Auth::id(),
        ]));

        toastr()->closeButton(true)->success('Godown Created Successfully');
        return redirect()->route('godowns.index')->with('success', 'Godown created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $godown = Godown::findOrFail($id);
        $users = User::all();
        $branches = Branch::all();

        return view('website.master.godowns.edit', compact('godown', 'users', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $godown = Godown::findOrFail($id);

        $request->validate([
            'godown_name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'mobile' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        $godown->update(array_merge($request->all(), [
            'user_id' => Auth::id(),
        ]));
        toastr()->closeButton(true)->success('Godown Updated Successfully');
        return redirect()->route('godowns.index')->with('success', 'Godown updated successfully.');
    }
}
