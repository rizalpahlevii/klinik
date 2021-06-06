<?php

namespace App\Http\Middleware;

use Closure;

class CashierShiftAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return getShift() ? 
            $next($request) : 
            abort(403);
    }
}
