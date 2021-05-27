<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CMS extends Model {
	protected $table = 'cms';

	public function fetchPages() {
		return CMS::where('status','=','AC')->get();
	}
}
