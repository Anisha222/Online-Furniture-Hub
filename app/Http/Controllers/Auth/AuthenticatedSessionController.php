<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
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
        $user = Auth::user();

        // --- TEMPORARY DEBUGGING - THIS WILL TELL US WHERE IT'S TRYING TO GO ---
        // Remove this dd() after debugging!
        if ($user && $user->is_admin) {
            // Remove this dd() after debugging!
            // dd("DEBUG: Admin logged in. Redirecting to admin.dashboard");
            return redirect()->route('admin.dashboard');
        } elseif ($user) {
            // Remove this dd() after debugging!
            // dd("DEBUG: User logged in. Redirecting to user.dashboard");
            return redirect()->route('user.dashboard');
        }

        // Fallback for unexpected scenarios
        return redirect()->route('home');
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