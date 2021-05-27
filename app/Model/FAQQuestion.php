<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FAQQuestion extends Model {
	protected $table = 'faq_questions';

	public function fetchquestions() {
		return FAQQuestion::all();
	}
}
