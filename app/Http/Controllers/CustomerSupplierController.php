<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerSupplier;

class CustomerSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('website.master.cust-sup.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.master.cust-sup.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:15',
            'address' => 'required',
            'customer_supplier' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
        ]);

        CustomerSupplier::create([
            'name' => $request->input('name'),
            'mobile_no' => $request->input('mobile_no'),
            'customer_supplier' => $request->input('customer_supplier'),
            'address' => $request->input('address'),
            'gst_no' => $request->input('gst_no'),
            'pan_no' => $request->input('pan_no'),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'user_id' => auth()->id(), 
            'ip_address' => $request->ip(), 
        ]);

        return redirect()->route('customer-supplier.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customerSupplier = CustomerSupplier::findOrFail($id);
        return view('website.master.cust-sup.show', compact('customerSupplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customerSupplier = CustomerSupplier::findOrFail($id);
        return view('website.master.cust-sup.edit', compact('customerSupplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:15',
            'address' => 'required',
            'customer_supplier' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
        ]);

        $customerSupplier = CustomerSupplier::findOrFail($id);
        $customerSupplier->update([
            'name' => $request->input('name'),
            'mobile_no' => $request->input('mobile_no'),
            'customer_supplier' => $request->input('customer_supplier'),
            'gst_no' => $request->input('gst_no'),
            'address' => $request->input('address'),
            'pan_no' => $request->input('pan_no'),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'user_id' => auth()->id(),  
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('customer-supplier.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customerSupplier = CustomerSupplier::findOrFail($id);
        $customerSupplier->delete();

        return redirect()->route('customer-supplier.index');
    }
}
