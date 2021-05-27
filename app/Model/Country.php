<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table='countries';
    // protected $with = ['state'];

    public function state()
    {
    	return $this->hasMany(State::class);
    }
}
