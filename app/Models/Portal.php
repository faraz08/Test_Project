<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portal extends Model
{
    protected $table = 'portal';
    public $timestamps = false;

    protected $fillable = ['id', 'name'];

    public function cases(){

        return $this->hasMany('App\Models\Cases');
    }

}
