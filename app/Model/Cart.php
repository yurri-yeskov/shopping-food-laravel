<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
	protected $table = 'cart';
    
	public function product_items() {
		return $this->hasOne(Product::class,'id');
	}


        public function product()
    {
        return $this->belongsTo(Product::class);
    }

        public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

        public function variation()
    {
        return $this->belongsTo(ProductVariation::class,'product_variation_id');
    }

}