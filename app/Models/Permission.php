<?php

namespace App\Models;

use App\Permissions\HasPermissionsTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasPermissionsTrait;

    //Permission.php
    public function roles() {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }

//    public function user() {
//        return $this->belongsToMany(User::class, 'users_roles');
//    }

//    All Permissions List

    public function allPermissions(){

        $all_permissions = Permission::leftJoin('roles_permissions', function($join) {
            $join->on('permissions.id', '=', 'roles_permissions.permission_id');
        })
            ->get();

        return $all_permissions;
    }

    public function scopeAllPermissionToRoles($query){

        return $query->leftjoin('roles.id', '=', 'roles_permissions.role_id');

    }

}
