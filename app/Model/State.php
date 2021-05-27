<?php

namespace App\Model;
use DB;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table='states';
    protected $with = ['country'];

    public function city()
    {
    	return $this->hasMany(City::class);
    }

    public function country()
    {
    	return $this->belongsTo(Country::class);
    }

    public static function getCities($state){
        $cities = City::whereHas('state', function($query) use($state){
                        $query->where('states.name', $state);
                    })->pluck('name');
        return $cities;
    }

}
