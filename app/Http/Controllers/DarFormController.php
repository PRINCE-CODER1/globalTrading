<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dar;
use App\Models\CustomerSupplier;
use App\Models\VisitMaster;
use App\Models\User;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class DarFormController extends Controller implements HasMiddleware
{
    public static function middleware(): array{
        return [
            new Middleware('permission:view dar-form', only: ['index']),
            new Middleware('permission:edit dar-form', only: ['edit']),
            new Middleware('permission:create dar-form', only: ['create']),
            new Middleware('permission:delete dar-form', only: ['destroy']),
        ];
    }
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            // Admins can see all DAR reports, grouped by user
            $dar = Dar::with(['customer', 'purposeOfVisit', 'user'])
                ->orderBy('user_id')
                ->latest('created_at')
                ->get()
                ->groupBy('user_id');
        } else {
            $dar = Dar::with(['customer', 'purposeOfVisit', 'user'])
                ->where('user_id', $user->id)
                ->latest('created_at')
                ->get();
        }

        return view('website.dar-form.list', compact('dar'));
    }

    public function create()
    {
        $customers = CustomerSupplier::all();
        $purposes = VisitMaster::all();
        $users = User::all();

        return view('website.dar-form.create', compact('customers', 'purposes', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customer_suppliers,id',
            'pov_id' => 'required|exists:visit_masters,id',
            'remarks' => 'nullable|string',
            'status' => 'required|in:0,1',
            'user_id' => 'required|exists:users,id',
            'rating' => 'nullable|integer|between:1,5',
        ]);

        $dar = new Dar([
            'customer_id' => $request->customer_id,
            'pov_id' => $request->pov_id,
            'date' => $request->date,
            'remarks' => $request->remarks,
            'status' => $request->status,
            'rating' => $request->rating,
            'user_id' => Auth::id(),
        ]);

        $dar->save();
        toastr()->closeButton(true)->success('DAR form created successfully!');
        return redirect()->route('daily-report.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dar = Dar::findOrFail($id);

        $customers = CustomerSupplier::all();
        $purposes = VisitMaster::all();
        $users = User::all();

        return view('website.dar-form.edit', compact('dar', 'customers', 'purposes', 'users'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customer_suppliers,id',
            'pov_id' => 'required|exists:visit_masters,id',
            'remarks' => 'nullable|string',
            'status' => 'required|in:0,1',
            'user_id' => 'required|exists:users,id',
            'rating' => 'nullable|integer|between:1,5',
        ]);

        $darForm = Dar::findOrFail($id);

        $darForm->update([
            'customer_id' => $request->customer_id,
            'pov_id' => $request->pov_id,
            'remarks' => $request->remarks,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);

        toastr()->closeButton(true)->success('DAR form updated successfully!');
        return redirect()->route('daily-report.index');
    }


    public function showDarRep()
    {
        $users = User::whereHas('dars')->withCount('dars')->get();
        return view('website.dar.list', compact('users'));
    }


    public function userReports($userId)
    {
        return view('website.dar.user-reports', compact('userId'));
    }
    public function agentDarReports(User $agent)
    {

        $dar = Dar::with('customer')
            ->where('user_id', $agent->id) 
            ->latest('created_at')
            ->get();

        return view('livewire.dar.agent-dar-reports', compact('dar', 'agent'));
    }

}
