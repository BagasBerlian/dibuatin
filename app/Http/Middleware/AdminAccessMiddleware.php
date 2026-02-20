<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (!Auth::check()) {
        //     return redirect()->route('login');
        // }

        // // Periksa apakah user memiliki akses admin
        // if (!Gate::allows('access-admin-panel')) {
        //     return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        // }

        if (Auth::check() && Auth::user()->role !== 'customer') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini');
    }
}
