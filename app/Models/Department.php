<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    protected $table = 'department';
    protected $fillable = ['department_name'];

    public function user(){

        return $this->hasMany('App\User');
    }

    public function manager(){

        return $this->hasMany('App\Manager');
    }

    static function departmentList(){

        return Department::all();
    }
}
