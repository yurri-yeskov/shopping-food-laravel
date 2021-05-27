<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class City extends Model {
	protected $table = 'cities';
	protected $visible = ["id", "name"];
	protected $with = ['state'];

	public function state()
	{
		return $this->belongsTo(State::class);
	}
}
