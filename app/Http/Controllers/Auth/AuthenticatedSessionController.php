<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check user role and handle
        $user = Auth::user();
        
        if ($user->hasRole('super admin')) {
            // Remove 'Agent' role if they are also 'Super Admin'
            $user->removeRole('agent');

            return redirect()->route('dashboard.index');
        } elseif ($user->hasRole('agent')) {
            return redirect()->route('agent.dashboard');
        } elseif ($user->hasRole('Manger')) {
            return redirect()->route('manger.dashboard');
        } else {
            return redirect()->intended(route('dashboard.index'));
        }

        return redirect()->intended(route('dashboard.index', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
