<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking for admin routes or non-GET requests if desired,
        // but for now let's just track all non-admin web visits.
        if (!$request->is('admin/*') && $request->isMethod('GET')) {
            try {
                \App\Models\VisitorLog::firstOrCreate([
                    'ip_address' => $request->ip(),
                    'visited_date' => now()->toDateString(),
                ], [
                    'user_agent' => substr($request->userAgent() ?? '', 0, 255),
                ]);
            } catch (\Exception $e) {
                // Ignore DB errors during tracking to not break the site
            }
        }

        return $next($request);
    }
}
