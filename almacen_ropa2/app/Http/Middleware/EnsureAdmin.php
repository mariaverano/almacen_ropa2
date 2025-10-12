<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdmin
{
    /** Handle an incoming request. */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('usuario_id')) {
            return redirect()->route('login');
        }

        if ($request->session()->get('usuario_rol') !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }

        return $next($request);
    }
}
