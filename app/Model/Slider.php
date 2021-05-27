<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model {
	protected $table = 'sliders';
    protected $fillable = [
        'name', 'image', 'status',
    ];

	public function get_all_sliders() {
		return Slider::where('status', '!=', 'DL')->orderBy("id","desc")->get();
	}
    
    public function scopeActive($query)
    {
        return $query->where('status','AC');
    }
    

}
