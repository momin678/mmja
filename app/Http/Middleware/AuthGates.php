<?php

namespace App\Http\Middleware;

use App\Permission;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthGates
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
        $user = Auth::user();
        if ($user) {
            $permissions = Permission::all();
            foreach ($permissions as $key => $permission) {
                Gate::define($permission->slug, function (User $user) use ($permission) {
                    return $user->hasPermission($permission->slug);
                });
            }
        }
        return $next($request);
    }
}
