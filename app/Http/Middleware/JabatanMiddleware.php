<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JabatanMiddleware
{
    public function handle(Request $request, Closure $next, ...$jabatan)
    {
        if (!Auth::check()) {
            return redirect('login-dashmin');
        }

        if (in_array(Auth::user()->jabatan, $jabatan)) {
            return $next($request);
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini');
    }
}
