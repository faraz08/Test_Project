<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public function permissions() {
        return $this->belongsToMany(Permission::class,'roles_permissions');

    }

    public function user() {
        return $this->belongsToMany(User::class, 'users_roles');
    }

//    public function roles() {
//        return $this->belongsToMany(Role::class,'roles_permissions');
//
//    }

//    All Roles List
    public function allRoles(){

        $all_roles = Role::leftJoin('roles_permissions', function($join) {
            $join->on('roles.id', '=', 'roles_permissions.role_id');
        })
            ->get();

        return $all_roles;
    }




}
