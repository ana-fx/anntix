<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip if the feature is disabled in .env
        if (!config('app.site_access_enabled')) {
            return $next($request);
        }

        // Don't block the access page itself
        if ($request->is('site-access*')) {
            return $next($request);
        }

        // Check if the site is already unlocked in the session
        if (session()->get('site_accessible')) {
            return $next($request);
        }

        // Redirect to password page
        return redirect()->route('site-access.index');
    }
}
