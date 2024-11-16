<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = Application::all();
        return view('website.master.application.list', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.master.application.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Application::create($request->all());
        toastr()
            ->closeButton(true)
            ->success('Application created successfully.');
        return redirect()->route('application.index');
    }

    public function edit(Application $application)
    {
        return view('website.master.application.edit', compact('application'));
    }

    public function update(Request $request, Application $application)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $application->update($request->all());
        toastr()
        ->closeButton(true)
        ->success('Application Updated successfully.');
        return redirect()->route('application.index');
    }

    public function destroy(Application $application)
    {
        $application->delete();

        toastr()
        ->closeButton(true)
        ->success('Application Deleted successfully.');
        return redirect()->route('application.index');
    }
}
