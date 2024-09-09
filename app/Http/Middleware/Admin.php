<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (Auth::user()->usertype != 'admin') {
        //     return redirect('/');
        // }
        // return $next($request);

        // Check if user is authenticated
        if (Auth::check()) {
            // Check if user is admin
            if (Auth::user()->usertype == 'admin') {
                return $next($request); // Proceed to admin dashboard
            } else {
                return redirect('/'); // Redirect non-admin users to home or user dashboard
            }
        }

        return redirect('/login'); // Redirect to login if not authenticated
    }
}
