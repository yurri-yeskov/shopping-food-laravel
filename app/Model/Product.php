<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    protected $fillable = ['name', 'h_name', 'image', 'brand_id', 'description','h_description', 'price', 'quantity', 'cgst', 'igst', 'sgst'];
    // protected $visible = ['id', 'name', 'image', 'brand_id', 'description', 'price', 'quantity', 'cgst', 'igst', 'sgst'];

    public function getProductImageAttribute(){
   
    if (!empty($this->image) && file_exists(public_path() . '/uploads/products/' . $this->image))
    {
        return asset('/uploads/products/'.$this->image) ;

    } else {
        
        return asset('/uploads/noproduct.png') ;
    }     
        
    }
    
    public function get_product_variations()
    {
        return $this->hasMany(ProductVariation::class, "product_id");
    }

    public function product_brand()
    {
        return $this->belongsTo(ProductBrand::class,'brand_id');
    }
    public function get_all_products()
    {
        return Product::with(["getCategory","getBrand"])->where('status', '!=', 'DL')->orderBy("id","desc")->get();
    }
    public function get_products_name($id)
    {
        return Product::where(['id' => $id, 'status' => 'AC'])->pluck('name');
    }

    public function getCategory(){
        return $this->belongsTo("App\Model\Category","category_id");
    }

    public function getBrand(){
        return $this->belongsTo("App\Model\ProductBrand","brand_id");
    }
    
    public function Category(){
        
        return $this->belongsTo("App\Model\Category","category_id");
    }
    
    public function users(){
        
        return $this->belongsToMany("App\Model\User",'favourite_products');
    }
    
    public function variations(){
        
        return $this->hasMany("App\Model\ProductVariation")->orderBy('price','ASC');
    }
    
    public function activevariations(){
        
        return $this->hasMany("App\Model\ProductVariation")->orderBy('price','ASC')->active()->with('unit')
            ->whereHas('unit', function ($query) {return $query
            ->where('product_units.status', 'AC');
            });
    }
    
    public function scopeName( $query, $name ) {
        return $query->where( 'name', 'like', $name . '%');
    }

    public function scopeSearch( $query, $term ) 
    {
        return $query->where( 'name', 'like','%'.  $term . '%')->orWhere( 'description', 'like','%'.  $term . '%');
    }

        public function orders()
    {
        return $this->hasMany(Order::class);
    }

        public function brand()
    {
        return $this->belongsTo(ProductBrand::class);
    }

        public function scopeActive($query)
    {
        return $query->where('status','AC');
    }
    
        public function scopeFeatured($query)
    {
        return $query->where('is_featured','1');
    }
    
        public function scopeQuickGrab($query)
    {
        return $query->where('is_quick_grab','1');
    }
    
        public function scopeOffered($query)
    {
        return $query->where('is_offered','1');
    }
    

}
