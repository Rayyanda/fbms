<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DivisionAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $posisi): Response
    {
        if(auth()->user()->role !== 'admin'){
            //memastikan apakah posisi karyawan sesuai
            if (! $request->user()->karyawan->posisi === $posisi) {
                // Redirect...
                //membuat pesan error menggunakan session flash
                session()->flash('error','Anda tidak memiliki akses ke halaman '.$posisi[0]);
                return redirect()->route('home');
            }
        }

        return $next($request);


    }
}
