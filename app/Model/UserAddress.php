<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_addresses';
    
    public function getFullAddressAttribute()
    {
    return $this->house_no.' '.$this->street_details.' '.$this->city.' '.$this->pincode;
    }

}
