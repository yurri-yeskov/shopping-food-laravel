<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    protected $table = 'brands';
    protected $fillable = ['name'];

    public function get_all_brands()
    {
        return ProductBrand::where('status', '!=', 'DL')->orderBy("id","desc")->get();
    }

}
