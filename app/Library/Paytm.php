<?php
namespace App\Library;

use App\Model\BusRuleRef;

class Paytm {

	//global variable to update paytm service variables
	public $settings;

	public function getConfig() {
		$settings = BusRuleRef::whereIn('rule_name', ['paytm_staging_mid', 'paytm_merchant_key', 'paytm_industry_type', 'paytm_channel_id', 'paytm_app_name'])->pluck('rule_value', 'rule_name');
		return $settings;
	}

	public function getChecksumFromArray($arrayList, $key, $sort = 1) {
		if ($sort != 0) {
			ksort($arrayList);
		}
		$str = $this->getArray2Str($arrayList);
		$salt = $this->generateSalt_e(4);
		$finalString = $str . "|" . $salt;
		$hash = hash("sha256", $finalString);
		$hashString = $hash . $salt;
		$checksum = $this->encrypt_e($hashString, $key);
		return $checksum;
	}

	public function getArray2Str($arrayList) {
		$findme = 'REFUND';
		$findmepipe = '|';
		$paramStr = "";
		$flag = 1;
		foreach ($arrayList as $key => $value) {
			$pos = strpos($value, $findme);
			$pospipe = strpos($value, $findmepipe);
			if ($pos !== false || $pospipe !== false) {
				continue;
			}

			if ($flag) {
				$paramStr .= $this->checkString_e($value);
				$flag = 0;
			} else {
				$paramStr .= "|" . $this->checkString_e($value);
			}
		}
		return $paramStr;
	}

	public function generateSalt_e($length) {
		$random = "";
		srand((double) microtime() * 1000000);

		$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
		$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
		$data .= "0FGH45OP89";

		for ($i = 0; $i < $length; $i++) {
			$random .= substr($data, (rand() % (strlen($data))), 1);
		}

		return $random;
	}

	public function encrypt_e($input, $ky) {
		$iv = "@@@@&&&&####$$$$";
		$data = openssl_encrypt($input, "AES-128-CBC", $ky, 0, $iv);
		return $data;
	}

	public function decrypt_e($crypt, $ky) {

		$crypt = base64_decode($crypt);
		$key = $ky;
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
		$iv = "@@@@&&&&####$$$$";
		mcrypt_generic_init($td, $key, $iv);
		$decrypted_data = mdecrypt_generic($td, $crypt);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		$decrypted_data = $this->pkcs5_unpad_e($decrypted_data);
		$decrypted_data = rtrim($decrypted_data);
		return $decrypted_data;
	}

	public function pkcs5_unpad_e($text) {
		$pad = ord($text{strlen($text) - 1});
		if ($pad > strlen($text)) {
			return false;
		}

		return substr($text, 0, -1 * $pad);
	}

	public function pkcs5_pad_e($text, $blocksize) {
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
	}

	public function checkString_e($value) {
		if ($value == 'null') {
			$value = '';
		}

		return $value;
	}

	public function verifychecksum_e($arrayList, $key, $checksumvalue) {
		$arrayList = $this->removeCheckSumParam($arrayList);
		ksort($arrayList);
		$str = $this->getArray2StrForVerify($arrayList);
		$paytm_hash = $this->decrypt_e($checksumvalue, $key);
		$salt = substr($paytm_hash, -4);

		$finalString = $str . "|" . $salt;

		$website_hash = hash("sha256", $finalString);
		$website_hash .= $salt;

		$validFlag = "FALSE";
		if ($website_hash == $paytm_hash) {
			$validFlag = "TRUE";
		} else {
			$validFlag = "FALSE";
		}
		return $validFlag;
	}

	public function removeCheckSumParam($arrayList) {
		if (isset($arrayList["CHECKSUMHASH"])) {
			unset($arrayList["CHECKSUMHASH"]);
		}
		return $arrayList;
	}

	public function getArray2StrForVerify($arrayList) {
		$paramStr = "";
		$flag = 1;
		foreach ($arrayList as $key => $value) {
			if ($flag) {
				$paramStr .= $this->checkString_e($value);
				$flag = 0;
			} else {
				$paramStr .= "|" . $this->checkString_e($value);
			}
		}
		return $paramStr;
	}
}

?>