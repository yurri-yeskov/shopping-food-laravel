<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model {
    protected $table = 'coupon_codes';
    protected $fillable = ['coupon_code', 'start_date', 'end_date', 'amount_type', 'discount_value', 'no_of_applies', 'min_amount', 'max_amount'];
}
