<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExternalChalaan;
use App\Models\Product;
use App\Models\ChallanType;
use App\Models\Branch;
use App\Models\Godown;
use App\Models\CustomerSupplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExternalChalaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $externalChalaans = ExternalChalaan::with(['product', 'chalaanType', 'branch', 'godown', 'customer', 'createdBy'])
            ->paginate(10);
        return view('website.chalaan.external.list',compact('externalChalaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $chalaanTypes = ChallanType::where('name', '!=', 'Branch Transfer')->get();
        $branches = Branch::all();
        $godowns = Godown::all();
        $customers = CustomerSupplier::where('customer_supplier','onlyCustomer')->get();
        $referenceId = 'EXT/' . str_pad(ExternalChalaan::count() + 1, 3, '0', STR_PAD_LEFT) . '/' . date('Y');
        return view('website.chalaan.external.create',compact('products', 'chalaanTypes', 'branches', 'godowns', 'customers','referenceId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'chalaan_type_id' => 'required|exists:challan_types,id',
        'branch_id' => 'required|exists:branches,id',
        'godown_id' => 'required|exists:godowns,id',
        'customer_id' => 'required|exists:customer_suppliers,id',
    ]);

     // Get the current year
     $year = date('Y');
     $productStock = Product::where('id', $request->product_id)
                    ->where('branch_id', $request->branch_id)
                    ->where('godown_id', $request->godown_id)
                    ->value('opening_stock');

    if (!$productStock || $request->quantity > $productStock) {
        return back()->withErrors(['quantity' => 'The quantity exceeds the available stock in the selected branch/godown.']);
    }

     // Generate the new incrementing number (003, 004, etc.)
     $latestChalaan = ExternalChalaan::whereYear('created_at', $year)->latest()->first();
     $newNumber = $latestChalaan ? (int)substr($latestChalaan->reference_id, 4, 3) + 1 : 1;
 
     // Create the reference ID in the format EXT/003/$year
     $referenceId = 'EXT/' . str_pad($newNumber, 3, '0', STR_PAD_LEFT) . '/' . $year;

    // Store the new chalaan
    ExternalChalaan::create([
        'reference_id' => $referenceId, 
        'product_id' => $request->product_id,
        'quantity' => $request->quantity,
        'chalaan_type_id' => $request->chalaan_type_id,
        'branch_id' => $request->branch_id,
        'godown_id' => $request->godown_id,
        'customer_id' => $request->customer_id,
        'created_by' => auth()->id(),  
        'user_id' => auth()->id(),  
    ]);
     // Deduct the quantity from the opening stock
     $product = Product::where('id', $request->product_id)
     ->where('branch_id', $request->branch_id)
     ->where('godown_id', $request->godown_id)
     ->first();

    if ($product) {
        $product->opening_stock -= $request->quantity;
        $product->save(); // Save the updated stock
    }

    return redirect()->route('external.index')->with('success', 'External Chalaan Created Successfully!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the input data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'chalaan_type_id' => 'required|exists:challan_types,id',
            'branch_id' => 'required|exists:branches,id',
            'godown_id' => 'required|exists:godowns,id',
            'customer_id' => 'required|exists:customer_suppliers,id',
            'created_by' => 'required|exists:users,id'
        ]);

        // Fetch the Chalaan
        $chalaan = ExternalChalaan::findOrFail($id);

        // Update the Chalaan details
        $chalaan->update($request->only(['product_id', 'quantity', 'chalaan_type_id', 'branch_id', 'godown_id', 'customer_id', 'created_by']));

        // Redirect with a success message
        return redirect()->route('external.index')->with('success', 'External Chalaan updated successfully!');
    }

    // Delete an External Chalaan
    public function destroy($id)
    {
        $chalaan = ExternalChalaan::findOrFail($id);
        $chalaan->delete();

        return redirect()->route('external.index')->with('success', 'External Chalaan deleted successfully!');
    }
}
