<?php
namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    //    public function handle($request, Closure $next, $role = null, $permission = null) //This is method will be used when passing rules and permission from routes so$roles and $permissions will get values from routes
    public function handle($request, Closure $next, $permission = null)
    {

        if (Auth::check() === false)
        {
            return redirect('login');
        }
        elseif (Auth::check() === true)
        {

            $roles = Role::all()->pluck('slug');

            if (is_null($request->user()) )
            {
                abort(404);
            }
            if (!$request->user()->hasRole($roles))
            {
                abort(404);
            }

            if ($request->user())
            {
                if ($request->user()->hasRole($roles))
                {
                    return $next($request);
                }
            }

            //            return $next($request);

        }

        //        if($permission !== null && !$request->user()->can($permission)) {
        //            abort(404);
        //        }
        //        return $next($request);

    }
}

