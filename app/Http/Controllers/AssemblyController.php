<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Godown;
use App\Models\Assembly;
use App\Models\AssembleDetail;
use App\Models\CustomerSupplier;
use App\Models\MasterNumbering;
use Illuminate\Support\Facades\Auth;

class AssemblyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all assemblies with related models
        $assemblies = Assembly::with(['product', 'branch', 'godown', 'user'])->get();
        return view('website.inventory-management.assembly.list', compact('assemblies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch necessary data for the form
        $masterNumbering = MasterNumbering::first();
        $purchaseOrderNo = $masterNumbering ? $masterNumbering->purchase_order_format : 'PO/001/XYZ';
        $products = Product::all();
        $branches = Branch::all();
        $suppliers = CustomerSupplier::all();
        $godowns = Godown::all();
        // Generate the Purchase Order No
        $masterNumbering = MasterNumbering::first();
        if (!$masterNumbering) {
            return redirect()->back()->withErrors(['error' => 'Master numbering not found.']);
        }

        $currentFormat = $masterNumbering->challan_format;
        preg_match('/(\d+)/', $currentFormat, $matches);
        $number = isset($matches[0]) ? intval($matches[0]) : 0;
        $number += 1; // Increment the number by 1 for the new challan number
        $purchaseOrderNo = sprintf("PO/%03d/XYZ", $number);

        return view('website.inventory-management.assembly.create', compact('purchaseOrderNo', 'products', 'branches', 'suppliers', 'godowns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log incoming request data for debugging purposes
        \Log::info('Request Data:', $request->all());

        // Validate incoming data
        $validatedData = $request->validate([
            'challan_no' => 'required|string',
            'date' => 'required|date',
            'product_id.*' => 'required|exists:products,id',
            'branch_id.*' => 'required|exists:branches,id',
            'godown_id.*' => 'required|exists:godowns,id',
            'quantity.*' => 'required|numeric',
            'price.*' => 'required|numeric',
        ]);

        // Fetch the current challan number from MasterNumbering
        $masterNumbering = MasterNumbering::first();
        if (!$masterNumbering) {
            return redirect()->back()->with('error', 'Master numbering not found.');
        }

        // Create a new assembly record
        $assembly = Assembly::create([
            'challan_no' => $validatedData['challan_no'],
            'date' => $validatedData['date'],
            'user_id' => Auth::id(), // Assuming user_id is the authenticated user
        ]);

        // Gather assembly details data
        $assemblyDetails = [];
        foreach ($request->input('product_id') as $index => $productId) {
            $assemblyDetails[] = [
                'assembly_id' => $assembly->id,
                'product_id' => $productId,
                'branch_id' => $request->input('branch_id')[$index],
                'godown_id' => $request->input('godown_id')[$index],
                'quantity' => $request->input('quantity')[$index],
                'price' => $request->input('price')[$index],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Log the assembly details data to ensure it's correct
        \Log::info('Assembly Details Data:', $assemblyDetails);

        // Save all assembly details
        AssembleDetail::insert($assemblyDetails);

        // Update MasterNumbering
        $currentFormat = $masterNumbering->challan_format;
        preg_match('/(\d+)/', $currentFormat, $matches);
        $number = isset($matches[0]) ? intval($matches[0]) : 0;
        $number += 1; // Increment the number by 1 for the new challan number
        $newFormat = sprintf("CH/%03d/GTE", $number);
        $masterNumbering->update(['challan_format' => $newFormat]);

        return redirect()->route('assemblies.index')->with('success', 'Assemblies created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assembly $assembly)
    {
        $products = Product::all();
        $branches = Branch::all();
        $godowns = Godown::all();

        return view('website.inventory-management.assembly.edit', compact('assembly', 'products', 'branches', 'godowns'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assembly $assembly)
    {
        $validatedData = $request->validate([
            'challan_no' => 'required|string',
            'date' => 'required|date',
            'product_id' => 'required|exists:products,id',
            'branch_id' => 'required|exists:branches,id',
            'godown_id' => 'required|exists:godowns,id',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $assembly->update($validatedData);

        return redirect()->route('assemblies.index')->with('success', 'Assembly updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assembly $assembly)
    {
        // Delete the specified assembly
        $assembly->delete();

        return redirect()->route('assemblies.index')->with('success', 'Assembly deleted successfully.');
    }
}
