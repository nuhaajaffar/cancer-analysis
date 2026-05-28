<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        if (!in_array(session('user_role'), $roles)) {
            abort(403, 'You are not allowed to access this page.');
        }

        return $next($request);
    }
}
