<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string $role ['superadmin', 'admin', 'agency', 'agent', 'user']
     * @param string $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $guard = null)
    {
        $user = auth()->guard($guard)->user();

        if (User::checkAccess($user, $role)) {
            return $next($request);
        } elseif (null === $guard) {
            if ($user) abort(403);
            return redirect('/login');
        }
        else return response()->json(['errors' => [__('User can\'t access this page')]], 403);
    }
}
