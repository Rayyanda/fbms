<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class roleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,string $role): Response
    {
        //mengecek apakah user role nya admin/karyawan
        if (! $request->user()->role === $role) {
            // Redirect...
            return redirect()->route('home');
        }
        return $next($request);
    }
}
