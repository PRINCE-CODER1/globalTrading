<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CustomerSupplier;
use App\Models\CustomerSupplierUser;

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile_no' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'customer_supplier' => 'required|in:onlySupplier,onlyCustomer,bothCustomerSupplier',
            'gst_no' => 'nullable|string|max:50',
            'country' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'names.*' => 'required|string|max:255',
            'email.*' => 'required|email|max:255',
            'phone.*' => 'required|string|max:20',
            'designation.*' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customerSupplier = CustomerSupplier::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
            'customer_supplier' => $request->customer_supplier,
            'gst_no' => $request->gst_no,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'ip_address' => $request->ip(),
        ]);

        foreach ($request->input('names', []) as $index => $name) {
            CustomerSupplierUser::create([
                'customer_supplier_id' => $customerSupplier->id,
                'name' => $name,
                'email' => $request->input('email')[$index],
                'phone' => $request->input('phone')[$index],
                'designation' => $request->input('designation')[$index],
            ]);
        }
        toastr()->closeButton(true)->success('Created successfully.');
        return redirect()->route('customer-supplier.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerSupplier $customerSupplier)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mobile_no' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'customer_supplier' => 'required|in:onlySupplier,onlyCustomer,bothCustomerSupplier',
            'gst_no' => 'nullable|string|max:50',
            'country' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'names.*' => 'required|string|max:255',
            'email.*' => 'required|email|max:255',
            'phone.*' => 'required|string|max:20',
            'designation.*' => 'required|string|max:100',
        ]);

        $customerSupplier->update([
            'name' => $validatedData['name'],
            'mobile_no' => $validatedData['mobile_no'],
            'customer_supplier' => $validatedData['customer_supplier'],
            'gst_no' => $validatedData['gst_no'],
            'address' => $validatedData['address'],
            'country' => $validatedData['country'],
            'state' => $validatedData['state'],
            'city' => $validatedData['city'],
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
        ]);

        $customerSupplier->users()->delete();

        foreach ($validatedData['names'] as $index => $name) {
            $customerSupplier->users()->create([
                'name' => $name,
                'email' => $validatedData['email'][$index],
                'phone' => $validatedData['phone'][$index],
                'designation' => $validatedData['designation'][$index],
            ]);
        }

        toastr()->closeButton(true)->success('Updated successfully.');
        return redirect()->route('customer-supplier.index')->with('success', 'Customer/Supplier updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customerSupplier = CustomerSupplier::findOrFail($id);
        $customerSupplier->delete();

        return redirect()->route('customer-supplier.index')->with('success', 'Customer/Supplier deleted successfully.');
    }
}
