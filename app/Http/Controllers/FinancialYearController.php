<?php

namespace App\Http\Controllers;

use App\Models\MasterNumbering;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FinancialYearController extends Controller
{
    public function getCurrentFinancialYear()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
        
        if ($currentMonth > 3) {
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        } else {
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        }
        
        return $startYear . '-' . $endYear;
    }

    public function getFinancialYears($startYear, $endYear)
    {
        $financialYears = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $financialYears[] = $year . '-' . ($year + 1);
        }
        return $financialYears;
    }

    public function index()
    {
        $currentYear = date('Y');
        $financialYears = $this->getFinancialYears($currentYear - 2, $currentYear);

        return view('website.master.master-numbering.index', compact('financialYears'));
    }

    public function store(Request $request)
{
    $request->validate([
        'financial_year' => 'required|string',
        'sale_order_prefix' => 'required|string',
        'sale_order_number' => 'required|integer',
        'sale_order_suffix' => 'required|string',
        'purchase_order_prefix' => 'required|string',
        'purchase_order_number' => 'required|integer',
        'purchase_order_suffix' => 'required|string',
        'in_transit_order_prefix' => 'required|string',
        'in_transit_order_number' => 'required|integer',
        'in_transit_order_suffix' => 'required|string',
        'challan_prefix' => 'required|string',
        'challan_number' => 'required|integer',
        'challan_suffix' => 'required|string',
        'sale_prefix' => 'required|string',
        'sale_number' => 'required|integer',
        'sale_suffix' => 'required|string',
        'purchase_prefix' => 'required|string',
        'purchase_number' => 'required|integer',
        'purchase_suffix' => 'required|string',
        'stock_transfer_prefix' => 'required|string',
        'stock_transfer_number' => 'required|integer',
        'stock_transfer_suffix' => 'required|string',
        'branch_to_workshop_transfer_prefix' => 'required|string',
        'branch_to_workshop_transfer_number' => 'required|integer',
        'branch_to_workshop_transfer_suffix' => 'required|string',
        'workshop_to_branch_transfer_prefix' => 'required|string',
        'workshop_to_branch_transfer_number' => 'required|integer',
        'workshop_to_branch_transfer_suffix' => 'required|string',
        'branch_to_customer_transfer_prefix' => 'required|string',
        'branch_to_customer_transfer_number' => 'required|integer',
        'branch_to_customer_transfer_suffix' => 'required|string',
        'customer_to_branch_transfer_prefix' => 'required|string',
        'customer_to_branch_transfer_number' => 'required|integer',
        'customer_to_branch_transfer_suffix' => 'required|string',
    ]);
    
    $formats = [
        'sale_order_format' => sprintf(
            "%s/%03d/%s",
            $request->sale_order_prefix,
            $request->sale_order_number,
            $request->sale_order_suffix
        ),
        'purchase_order_format' => sprintf(
            "%s/%03d/%s",
            $request->purchase_order_prefix,
            $request->purchase_order_number,
            $request->purchase_order_suffix
        ),
        'in_transit_order_format' => sprintf(
            "%s/%03d/%s",
            $request->in_transit_order_prefix,
            $request->in_transit_order_number,
            $request->in_transit_order_suffix
        ),
        'challan_format' => sprintf(
            "%s/%03d/%s",
            $request->challan_prefix,
            $request->challan_number,
            $request->challan_suffix
        ),
        'sale_format' => sprintf(
            "%s/%03d/%s",
            $request->sale_prefix,
            $request->sale_number,
            $request->sale_suffix
        ),
        'purchase_format' => sprintf(
            "%s/%03d/%s",
            $request->purchase_prefix,
            $request->purchase_number,
            $request->purchase_suffix
        ),
        'stock_transfer_format' => sprintf(
            "%s/%03d/%s",
            $request->stock_transfer_prefix,
            $request->stock_transfer_number,
            $request->stock_transfer_suffix
        ),
        'branch_to_workshop_transfer_format' => sprintf(
            "%s/%03d/%s",
            $request->branch_to_workshop_transfer_prefix,
            $request->branch_to_workshop_transfer_number,
            $request->branch_to_workshop_transfer_suffix
        ),
        'workshop_to_branch_transfer_format' => sprintf(
            "%s/%03d/%s",
            $request->workshop_to_branch_transfer_prefix,
            $request->workshop_to_branch_transfer_number,
            $request->workshop_to_branch_transfer_suffix
        ),
        'branch_to_customer_transfer_format' => sprintf(
            "%s/%03d/%s",
            $request->branch_to_customer_transfer_prefix,
            $request->branch_to_customer_transfer_number,
            $request->branch_to_customer_transfer_suffix
        ),
        'customer_to_branch_transfer_format' => sprintf(
            "%s/%03d/%s",
            $request->customer_to_branch_transfer_prefix,
            $request->customer_to_branch_transfer_number,
            $request->customer_to_branch_transfer_suffix
        ),
        'user_id' => Auth::id(),
    ];

    try {
        $result = MasterNumbering::updateOrCreate(
            ['financial_year' => $request->financial_year],
            $formats
        );

        // Debugging output
        \Log::info('MasterNumbering created/updated:', $result->toArray());
        toastr()->closeButton(true)->success('Formats saved successfully.');

        return redirect()->route('master_numbering.index');
    } catch (\Exception $e) {
        \Log::error('Error saving MasterNumbering:', ['error' => $e->getMessage()]);
        toastr()->closeButton(true)->error('An error occurred while saving the data.');
        return redirect()->back();
    }
}

    
}
