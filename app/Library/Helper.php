<?php
namespace App\Library;
use Config;
use DB;

class Helper {

	public static function generateNumber($table, $column) {
		do {
			$random  = mt_rand(10000, 99999);
			$uid     = Config::get('constants.UID.' . $table) . $random;
			$exists  = DB::table($table)->where($column, $uid)->count();
		} while ($exists > 0);
		return $uid;
	}
}

?>