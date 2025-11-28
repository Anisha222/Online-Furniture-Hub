<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // IMPORTANT: Add this import if not already there
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // --- REMOVE OR COMMENT OUT THIS LINE ---
        // dd("IS ADMIN MIDDLEWARE: User:", Auth::user() ? Auth::user()->email : 'Not Logged In', "Is Admin Flag:", Auth::user() ? Auth::user()->is_admin : 'N/A');
        // --- END REMOVED DD() ---

        if (Auth::check() && Auth::user()->is_admin === true) { // Using 'true' for boolean casted values is good
            return $next($request);
        }

        // If not an admin, redirect to the user dashboard or home page
        return redirect()->route('user.dashboard');
    }
}