<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SystemManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user() || auth()->user()->position != 'SYSTEM MANAGER') {
            abort(403, "You don't have permission to access this page.");
        }

        return $next($request);
    }
}
