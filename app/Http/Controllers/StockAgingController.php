<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockAging;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\StockAgingNotificationEmail;

class StockAgingController extends Controller
{
    // List stock aging records
    public function index()
    {
        $user = Auth::user();
        $stockAging = StockAging::with('product')
            ->whereHas('product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->paginate(10);

        return view('website.master.stock-aging.index', ['stockAging' => $stockAging]);
    }

    // Show the form to create a new stock aging record
    public function create()
    {
        $products = Product::all();
        return view('website.master.stock-aging.create', ['products' => $products]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'received_at' => 'required|date',
        ]);

        $receivedAt = Carbon::parse($request->received_at);
        $ageDays = max(0, now()->diffInDays($receivedAt));
        $ageCategory = $this->determineAgeCategory($ageDays);

        StockAging::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'received_at' => $receivedAt,
            'age_days' => $ageDays,
            'age_category' => $ageCategory
        ]);

        return redirect()->route('stock-aging.index')->with('success', 'Stock Aging record added successfully.');
    }

    // Show the form for editing the specified stock aging record
    public function edit(StockAging $stockAging)
    {
        $products = Product::all();
        return view('website.master.stock-aging.edit', compact('stockAging', 'products'));
    }

    // Update the specified stock aging record
    public function update(Request $request, StockAging $stockAging)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'received_at' => 'required|date',
        ]);

        $receivedAt = Carbon::parse($request->received_at);
        $ageDays = max(0, now()->diffInDays($receivedAt));
        $ageCategory = $this->determineAgeCategory($ageDays);

        $stockAging->update([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'received_at' => $receivedAt,
            'age_days' => $ageDays,
            'age_category' => $ageCategory
        ]);

        return redirect()->route('stock-aging.index')->with('success', 'Stock Aging record updated successfully.');
    }


    // Remove the specified stock aging record
    public function destroy(StockAging $stockAging)
    {
        $stockAging->delete();
        return redirect()->route('stock-aging.index')->with('success', 'Stock Aging record deleted successfully.');
    }

    // Handle stock aging data and notifications
    public function updateStockAgingData()
    {
        $user = Auth::user();
        // Fetch all products
        $products = Product::where('user_id', $user->id)->get();

        // Prepare stock aging data
        $stockAgingData = $products->map(function ($product) {
            // Parse the received_at date
            $receivedAt = Carbon::parse($product->received_at);

            // Calculate the age in whole days
            $ageDays = max(0, now()->diffInDays($receivedAt));

            // Determine age category
            $ageCategory = $this->determineAgeCategory($ageDays);

            // Store or update stock aging data
            StockAging::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'quantity' => $product->opening_stock,
                    'received_at' => $receivedAt, 
                    'age_days' => $ageDays,
                    'age_category' => $ageCategory
                ]
            );

            // Send email notification if certain age thresholds are surpassed
            $this->sendStockAgingEmail($product, $ageDays);

            return [
                'product' => $product,
                'age' => $ageDays,
                'ageCategory' => $ageCategory
            ];
        });

        // Return view if needed or handle data as required
        // return view('website.master.stock-aging.index', ['stockAging' => $stockAgingData]);
    }

    private function determineAgeCategory($ageDays)
    {
        if ($ageDays <= 30) {
            return 'Less than a month';
        } elseif ($ageDays <= 60) {
            return '1 to 2 months';
        } elseif ($ageDays <= 90) {
            return '2 to 3 months';
        } else {
            return 'More than 3 months';
        }
    }

    private function sendStockAgingEmail($product, $ageDays)
    {
        // Check if the product's age is 30 days or more
        if ($ageDays >= 30) {
            // Get the user associated with the product
            $user = $product->user;

            // Send an email to the user if they are found
            if ($user) {
                Mail::to($user->email)->send(new StockAgingNotificationEmail($product, $ageDays));
            }
        }
    }
}
