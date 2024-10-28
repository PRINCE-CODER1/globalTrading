<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnChalaan;
use App\Models\ExternalChalaan;
use App\Models\Branch;
use App\Models\Godown;

class ReturnChalaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('website.chalaan.return.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.chalaan.return.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $returnChalaan = ReturnChalaan::with(['externalChalaan', 'returnedBy', 'returnChalaanProducts.product', 'returnChalaanProducts.godown', 'returnChalaanProducts.branch'])
        ->findOrFail($id);
        return view('website.chalaan.return.show',compact('returnChalaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $returnChalaan = ReturnChalaan::with('returnChalaanProducts')->findOrFail($id);
        $externalChalaans = ExternalChalaan::all();
        $branches = Branch::all();
        $godowns = Godown::all();

        return view('website.chalaan.return.edit', compact('returnChalaan', 'externalChalaans', 'branches', 'godowns'),['returnChalaanId' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
