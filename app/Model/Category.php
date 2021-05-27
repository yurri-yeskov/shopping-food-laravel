<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = ['name','h_name', 'image'];

    public function get_all_category()
    {
        return Category::where('status', '!=', 'DL')->orderBy("id","desc")->get();
    }
    
    public function Products(){
        
        return $this->hasMany("App\Model\Product")->orderBy('name','ASC');
    }
    
    public function getCategoryImageAttribute(){
   
    if (!empty($this->image) && file_exists(public_path() . '/uploads/categories/' . $this->image))
    {
        return asset('/uploads/categories/'.$this->image) ;

    } else 
    {
        
        return asset('/uploads/noproduct.png') ;
    }     
        
    }
    
        public function ActiveProducts(){
        
        return $this->hasMany("App\Model\Product")->orderBy('name','ASC')->with('activevariations')
        ->active();
    }
    

        public function scopeActive($query)
    {
        return $query->where('status','AC');
    }
    


}
