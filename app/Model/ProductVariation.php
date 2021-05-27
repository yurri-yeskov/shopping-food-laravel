<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $table = 'product_variations';
    protected $fillable = ['product_id', 'unit_id', 'weight','price'];

    public function product_units()
    {
        return $this->belongsTo(ProductUnit::class, 'unit_id');
    }
    public function get_all_variations()
    {
        return ProductVariation::where('status', '!=', 'DL')->orderBy("id","desc")->get();
    }
    // public function get_product()
    // {
    //   return $this->belongsTo(ProductVariation::class,'product_id');
    // }
    
        public function product()
    {
        return $this->belongsTo('App\Model\Product');
    }
        
        public function unit()
    {
        return $this->belongsTo('App\Model\ProductUnit');
    }

        public function activeunit()
    {
        return $this->belongsTo('App\Model\ProductUnit')->where('status','AC')->withDefault();
    }

        public function scopeActive($query)
    {
        return $query->where('status','AC');
    }
    

}
