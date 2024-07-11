<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotProperRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $empleado= Auth::Empleados();
        if ($empleado->cargo != 'admin') {
            return redirect('/dashboard_index');
        }
        if ($empleado->cargo != 'vendedor') {
            return redirect('/dashboard_index');
        }
        if ($empleado->cargo != 'gerente') {
            return redirect('/dashboard_index');
        }
        return $next($request);
    }
}
