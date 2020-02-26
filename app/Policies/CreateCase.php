<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CreateCase
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create_case(User $user){

        if($user->hasRole(['admin']) ||$user->hasRole(['operator']) && $user->hasPermissionTo('create')){

            return true;
        }else
            return false;

    }
}
