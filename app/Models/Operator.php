<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $table = 'operator';
//    public $timestamps = false;

    protected $fillable = ['name'];

    public function patients()
    {
        return $this->hasMany('App\Models\Patient');
    }
}
