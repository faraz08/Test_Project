<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    public function department(){

        return $this->belongsTo('App\Models\Department');
    }
}
