<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasCompany
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            if (auth()->user()->is_super_admin) {
                return $next($request);
            }

            if (auth()->user()->company_id && auth()->user()->company->status === 'active') {
                return $next($request);
            }

            // You might want to redirect to a page explaining they need to be part of a company
            // or their company is inactive.
            abort(403, 'Your account is not associated with an active company.');
        }

        return $next($request);
    }
}
