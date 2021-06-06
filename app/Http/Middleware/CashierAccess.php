<?php

namespace App\Http\Middleware;

use Closure;

class CashierAccess
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
        return auth()->user()->hasAnyRole(['cashier', 'owner']) ?
            $next($request) :
            abort(403);
    }
}
