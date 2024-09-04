<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerSupplier;
use App\Models\Purchase;
use App\Models\Branch;
use App\Models\Godown;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\MasterNumbering;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $suppliers = CustomerSupplier::where('customer_supplier', 'onlySupplier')->get();
        $supplierId = $request->query('supplier_id');

        $purchaseOrders = collect();
        if ($supplierId) {
            $purchaseOrders = Purchase::where('supplier_id', $supplierId)->paginate(10);
        }

        return view('website.inventory-management.purchase.list', compact('purchaseOrders', 'suppliers', 'supplierId'));
    }

    public function create(Request $request)
    {
        $supplierId = $request->query('supplier_id'); // Get supplier ID from the request if available

        $suppliers = CustomerSupplier::where('customer_supplier', 'onlySupplier')->get();
        $branches = Branch::all();
        $products = Product::all();
        $godowns = Godown::all();

        // Generate the Purchase Order No
        $masterNumbering = MasterNumbering::first();
        if (!$masterNumbering) {
            return redirect()->back()->withErrors(['error' => 'Master numbering not found.']);
        }

        // Increment the number for the new purchase order
        preg_match('/(\d+)/', $masterNumbering->purchase_format, $matches);
        $number = isset($matches[0]) ? intval($matches[0]) : 0;
        $number += 1; // Increment the number by 1 for the new purchase order number
        $purchaseOrderNo = sprintf("PE/%03d/WV", $number);

        // Fetch purchase orders based on the selected supplier
        $purchaseOrders = $supplierId
            ? PurchaseOrder::where('supplier_id', $supplierId)->get()
            : PurchaseOrder::all();

        return view('website.inventory-management.purchase.create', compact('suppliers', 'branches', 'products', 'godowns', 'purchaseOrderNo', 'purchaseOrders', 'supplierId'));
    }

    public function edit($id)
    {
        $purchase = Purchase::findOrFail($id);
        return view('website.inventory-management.purchase.edit', compact('purchase'),['purchaseId' => $id]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->items()->delete();
        $purchase->delete();
        return redirect()->route('purchase.index')->with('success', 'Purchase deleted successfully');
    }
}
