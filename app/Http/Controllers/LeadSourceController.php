<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\LeadSource;

class LeadSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leadSources = LeadSource::all();
        return view('website.master.leads.list', compact('leadSources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.master.leads.create');
    }
    public function edit(string $id)
    {
        $leadSource = LeadSource::findOrFail($id);
        return view('website.master.leads.edit', compact('leadSource'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:lead_sources|min:3',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]);

        if ($validator->passes()) {
            LeadSource::create([
                'name' => $request->name,
                'description' => $request->description,
                'active' => $request->active,
                'user_id' => Auth::id(),
            ]);

            toastr()->closeButton(true)->success('Lead Source Added Successfully');
            return redirect()->route('lead-source.index');
        } else {
            toastr()->closeButton(true)->error('Validation failed');
            return redirect()->route('lead-source.create')->withErrors($validator)->withInput();
        }
    }



    public function update(Request $request, string $id)
    {
        $leadSource = LeadSource::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'min:3',
                Rule::unique('lead_sources', 'name')->ignore($id)
            ],
            'description' => 'nullable|string',
            'active' => 'required|boolean',
        ]);

        if ($validator->passes()) {
            $leadSource->update([
                'name' => $request->name,
                'description' => $request->description,
                'active' => $request->active,
            ]);

            toastr()->closeButton(true)->success('Lead Source Updated Successfully');
            return redirect()->route('lead-source.index');
        } else {
            toastr()->closeButton(true)->error('Validation failed');
            return redirect()->route('lead-source.edit', $id)->withErrors($validator)->withInput();
        }
    }



    public function destroy(LeadSource $leadSource)
    {
        $leadSource->delete();
        return redirect()->route('lead-source.index')->with('success', 'Lead source deleted successfully.');
    }
}
