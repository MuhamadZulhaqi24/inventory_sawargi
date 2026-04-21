<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (auth()->check()) {
            if (auth()->user()->is_super_admin) {
                return $next($request);
            }

            if (auth()->user()->hasPermission($permission)) {
                return $next($request);
            }

            abort(403, 'You do not have permission to access this module.');
        }

        return $next($request);
    }
}
