<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::directive('role', function ($role){

            return "<?php if(auth()->check() && auth()->user()->hasRole({$role})) { ?>";
        });
        Blade::directive('endrole', function (){
            return "<?php } ?>";
        });


        Blade::directive('permission', function ($permission){

            return "<?php if(auth()->check() && auth()->user()->hasPermission({$permission}) || auth()->check() && auth()->user()->isAdmin() ) { ?>";

        });
        Blade::directive('endpermission', function (){
            return "<?php } ?>";
        });

        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }


    }
}
