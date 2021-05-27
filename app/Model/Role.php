<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table='roles';

    public function role()
    {
        return $this->belongsToMany('App\Model\User');
    }
}
