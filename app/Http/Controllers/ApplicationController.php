<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ApplicationController extends Controller implements HasMiddleware
{
    public static function middleware(): array{
        return [
            new Middleware('permission:view application', only: ['index']),
            new Middleware('permission:edit application', only: ['edit']),
            new Middleware('permission:create application', only: ['create']),
            new Middleware('permission:delete application', only: ['destroy']),
        ];
    }
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
