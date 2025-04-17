<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $user = Auth::user();

        // Use the isAdmin() method for 'admin' role, otherwise compare directly
        if ($role === 'admin' && !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        } elseif ($user->role !== $role) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}