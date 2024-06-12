<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanManageUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user() || (!auth()->user()->isSystemManager() && !auth()->user()->isHeadOfDepartment())) {
            abort(403, "You do not have access to this page.");
        }

        return $next($request);
    }
}
