<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UnitOfMeasurement;

class UnitOfMeasurementController extends Controller
{
    public function index()
    {
        return view('website.master.units.list');
    }

    public function create()
    {
        return view('website.master.units.create');
    }

    public function edit(UnitOfMeasurement $unit)
    {
        return view('website.master.units.edit', compact('unit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'symbol' => 'required|string|max:255',
            'formula_name' => 'required|string|max:255',
            'has_decimals' => 'nullable|boolean',
            'decimal_places' => 'nullable|integer|min:0|max:10|required_if:has_decimals,1',
        ]);

        $unit = new UnitOfMeasurement();
        $unit->symbol = $validated['symbol'];
        $unit->formula_name = $validated['formula_name'];
        $unit->has_decimals = $validated['has_decimals'] ?? 0;
        $unit->decimal_places = $unit->has_decimals ? $validated['decimal_places'] : 0;
        $unit->user_id = Auth::id();
        $unit->save();
        return redirect()->route('units.index');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'symbol' => 'required|string|max:255',
            'formula_name' => 'required|string|max:255',
            'has_decimals' => 'nullable|boolean',
            'decimal_places' => 'nullable|integer|min:0|max:10|required_if:has_decimals,1',
        ]);

        $unit = UnitOfMeasurement::findOrFail($id);
        $unit->symbol = $validated['symbol'];
        $unit->formula_name = $validated['formula_name'];
        $unit->has_decimals = $validated['has_decimals'] ?? 0;

        // Set decimal_places to 0 if has_decimals is false
        $unit->decimal_places = $unit->has_decimals ? $validated['decimal_places'] : 0;

        $unit->save();

        return redirect()->route('units.index');
    }

    // public function destroy(UnitOfMeasurement $unit)
    // {
    //     $unit->delete();
    //     return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
    // }
}
