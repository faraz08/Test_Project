<?php

namespace App;

use App\Models\Role;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;
    use HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'name', 'email', 'password', 'remember_token', 'status', 'department_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getUserWithRoles()
    {

        $getUserWithRoles = User::with('roles', 'permissions')->get();

        return $getUserWithRoles;
    }

    public function isAdmin()
    {

        return Auth::user()->roles()->where('name', 'admin')->exists();
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }
//    public function roles(){
//        return $this->belongsToMany(Role::class,'users_roles');
//    }
}
