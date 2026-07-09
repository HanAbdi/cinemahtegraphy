<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = auth()->user();

        if ($user->role === 'superadmin') {
            return $next($request);
        }

        $permissions = $user->permissions ?? [];
        if (!in_array($permission, $permissions)) {
            abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk mengakses fitur ini.');
        }

        return $next($request);
    }
}
