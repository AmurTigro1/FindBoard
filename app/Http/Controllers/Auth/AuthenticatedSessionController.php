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
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return redirect()->intended(route('dashboard', absolute: false));
    // }
    public function store(LoginRequest $request): RedirectResponse
{
    // Authenticate the user
    $request->authenticate();

    // Regenerate session to prevent session fixation
    $request->session()->regenerate();

    $user = Auth::user();

    // Check if the user came from the "List your Property" button
    if ($request->query('action') === 'list_property') {
        // Update user role to 'landlord' if it's not already
        if ($user->role !== 'landlord') {
            $user->role = 'landlord';
            $user->save(); // Save changes to the database
        }

        // Redirect to the boarding house creation page
        return redirect()->route('boarding-house.create');
    }

    // Handle role-based redirection
    if ($user->role === 'admin') {
        return redirect(route('admin.dashboard'));
    }

    if ($user->role === 'landlord') {
        return redirect(route('dashboard'));
    }

    // Default redirection for regular users
    return redirect()->route('dashboard');
}




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
