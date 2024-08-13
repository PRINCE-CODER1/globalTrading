<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Segment;
use App\Models\Branch;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\CustomerSupplier;
use App\Models\MasterNumbering;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $purchaseOrders = PurchaseOrder::with(['supplier', 'customer', 'agent', 'segment', 'orderBranch', 'deliveryBranch', 'user'])->paginate(10);
        return view('website.inventory-management.purchase-orders.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $suppliers = CustomerSupplier::where('customer_supplier', 'only supplier')->get();
        $customers = CustomerSupplier::where('customer_supplier', 'only customer')->get();
        $agents = User::all(); // Replace with appropriate query if needed
        $segments = Segment::all();
        $branches = Branch::all();

        // Generate the Purchase Order No
        $masterNumbering = MasterNumbering::first();
        if (!$masterNumbering) {
            return redirect()->back()->withErrors(['error' => 'Master numbering not found.']);
        }

        $currentFormat = $masterNumbering->challan_format;
        preg_match('/(\d+)/', $currentFormat, $matches);
        $number = isset($matches[0]) ? intval($matches[0]) : 0;
        $number += 1; // Increment the number by 1 for the new challan number
        $purchaseOrderNo = sprintf("CH/%03d/GTE", $number);

        return view('website.inventory-management.purchase-orders.create', compact('products', 'suppliers', 'customers', 'agents', 'segments', 'branches', 'purchaseOrderNo'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'date' => 'required|date',
            'supplier_id' => 'required|exists:customer_suppliers,id',
            'supplier_sale_order_no' => 'nullable|string',
            'agent_id' => 'required|exists:users,id',
            'segment_id' => 'required|exists:segments,id',
            'order_branch_id' => 'required|exists:branches,id',
            'delivery_branch_id' => 'required|exists:branches,id',
            'customer_id' => 'nullable|exists:customer_suppliers,id',
            'customer_sale_order_no' => 'nullable|string',
            'customer_sale_order_date' => 'nullable|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric',
            'items.*.price' => 'required|numeric',
            'items.*.discount' => 'nullable|numeric|min:0|max:100',
        ]);

        // Calculate subtotal
        $subtotal = 0;
        foreach ($request->input('items', []) as $item) {
            $subtotal += $item['quantity'] * $item['price'];
        }

        // Generate the Purchase Order No
        $masterNumbering = MasterNumbering::first();
        if (!$masterNumbering) {
            return redirect()->back()->withErrors(['error' => 'Master numbering not found.']);
        }

        $currentFormat = $masterNumbering->challan_format;
        preg_match('/(\d+)/', $currentFormat, $matches);
        $number = isset($matches[0]) ? intval($matches[0]) : 0;
        $number += 1; // Increment the number by 1 for the new purchase order number
        $purchaseOrderNo = sprintf("CH/%03d/GTE", $number);

        // Create the PurchaseOrder
        $purchaseOrder = PurchaseOrder::create([
            'purchase_order_no' => $purchaseOrderNo,
            'date' => $request->date,
            'supplier_id' => $request->supplier_id,
            'supplier_sale_order_no' => $request->supplier_sale_order_no,
            'agent_id' => $request->agent_id,
            'segment_id' => $request->segment_id,
            'order_branch_id' => $request->order_branch_id,
            'delivery_branch_id' => $request->delivery_branch_id,
            'customer_id' => $request->customer_id,
            'customer_sale_order_no' => $request->customer_sale_order_no,
            'customer_sale_order_date' => $request->customer_sale_order_date,
            'user_id' => Auth::id(),
            'subtotal' => $subtotal, // Add this line
        ]);

        // Save PurchaseOrderItems
        $items = [];
        foreach ($request->input('items', []) as $item) {
            $items[] = [
                'purchase_order_id' => $purchaseOrder->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'discount' => $item['discount'] ?? 0,
            ];
        }

        if (!empty($items)) {
            PurchaseOrderItem::insert($items);
        }

        // Update MasterNumbering
        $masterNumbering->update(['challan_format' => $purchaseOrderNo]);

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase Order created successfully.');
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
        // Fetch the purchase order and related data
        $purchaseOrder = PurchaseOrder::with('items.product')->findOrFail($id);
        $products = Product::all();
        $suppliers = CustomerSupplier::where('customer_supplier', 'only supplier')->get();
        $customers = CustomerSupplier::where('customer_supplier', 'only customer')->get();
        $agents = User::all();
        $segments = Segment::all();
        $branches = Branch::all();

        return view('website.inventory-management.purchase-orders.edit', compact('purchaseOrder', 'products', 'suppliers', 'customers', 'agents', 'segments', 'branches'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'date' => 'required|date',
            'supplier_id' => 'required|exists:customer_suppliers,id',
            'supplier_sale_order_no' => 'nullable|string',
            'agent_id' => 'required|exists:users,id',
            'segment_id' => 'required|exists:segments,id',
            'order_branch_id' => 'required|exists:branches,id',
            'delivery_branch_id' => 'required|exists:branches,id',
            'customer_id' => 'nullable|exists:customer_suppliers,id',
            'customer_sale_order_no' => 'nullable|string',
            'customer_sale_order_date' => 'nullable|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric',
            'items.*.price' => 'required|numeric',
            'items.*.discount' => 'nullable|numeric|min:0|max:100',
        ]);

        // Calculate subtotal
        $subtotal = 0;
        foreach ($request->input('items', []) as $item) {
            $subtotal += $item['quantity'] * $item['price'];
        }

        // Update the PurchaseOrder
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->update([
            'date' => $request->date,
            'supplier_id' => $request->supplier_id,
            'supplier_sale_order_no' => $request->supplier_sale_order_no,
            'agent_id' => $request->agent_id,
            'segment_id' => $request->segment_id,
            'order_branch_id' => $request->order_branch_id,
            'delivery_branch_id' => $request->delivery_branch_id,
            'customer_id' => $request->customer_id,
            'customer_sale_order_no' => $request->customer_sale_order_no,
            'customer_sale_order_date' => $request->customer_sale_order_date,
            'user_id' => Auth::id(),
            'subtotal' => $subtotal,
        ]);

        // Handle PurchaseOrderItems
        $existingItemIds = PurchaseOrderItem::where('purchase_order_id', $id)->pluck('id')->toArray();
        $updatedItemIds = [];

        foreach ($request->input('items', []) as $item) {
            // Update or create items
            $purchaseOrderItem = PurchaseOrderItem::updateOrCreate(
                ['id' => $item['id'] ?? null],
                [
                    'purchase_order_id' => $purchaseOrder->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'discount' => $item['discount'] ?? 0, 
                ]
            );
            $updatedItemIds[] = $purchaseOrderItem->id;
        }

        // Remove any items that were not included in the update
        $deletedItemIds = array_diff($existingItemIds, $updatedItemIds);
        if (!empty($deletedItemIds)) {
            PurchaseOrderItem::destroy($deletedItemIds);
        }

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase Order updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
