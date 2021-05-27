<?php

namespace App\Http\Controllers;

use App\Library\ResponseMessages;
use App\Model\BusRuleRef;
use App\Model\User;
use DB;

class MyController extends Controller {

    public $response = array(
        "status" => 500,
        "message" => "Internal server error",
    );

    // function __construct(Request $request) {
    // }
    // function __destruct() {
    //     echo json_encode($this->response);
    // }

    public function shut_down() {
        echo json_encode($this->response);
    }

    public function checkKeys($input = array(), $required = array()) {
        // print_r(!array_diff_key(array_flip($input), $required));
        $existance = implode(", ", array_diff($required, $input));
        if (!empty($existance)) {
            if (count(array_diff($required, $input)) == 1) {
                $this->response = array(
                    "status" => 101,
                    "message" => $existance . " key is missing",
                );
            } else {
                $this->response = array(
                    "status" => 101,
                    "message" => $existance . " keys are missing",
                );
            }
            $this->shut_down();
            exit;
        }
    }

    public function checkUserActive($userId) {
        if ($user = User::select("status")->where("id", $userId)->first()) {
            if ($user->status == "AC") {
                return true;
            } else {
                $this->response = array(
                    "status" => 216,
                    "message" => ResponseMessages::getStatusCodeMessages(216),
                );
                $this->shut_down();
                exit;
            }
        } else {
            $this->response = array(
                "status" => 321,
                "message" => ResponseMessages::getStatusCodeMessages(321),
            );
            $this->shut_down();
            exit;
        }
    }

    public function checkSingleSignOn($userId, $deviceId) {
        if (!empty($userId) && !empty($deviceId)) {
            if ($user = User::select("device_id")->find($userId)) {
                if ($user->device_id == $deviceId) {
                    return true;
                } else {
                    $this->response = array(
                        "status" => 331,
                        "message" => ResponseMessages::getStatusCodeMessages(331),
                    );
                    $this->shut_down();
                    exit;
                }
            } else {
                $this->response = array(
                    "status" => 321,
                    "message" => ResponseMessages::getStatusCodeMessages(321),
                );
                $this->shut_down();
                exit;
            }
        } else {
            $this->response = array(
                "status" => 101,
                "message" => ResponseMessages::getStatusCodeMessages(101),
            );
            $this->shut_down();
            exit;
        }
    }

    public function updateUserStatus($userId, $status) {
        $user = User::where("id", $userId)->update(["user_status" => $status]);
    }

    public function getBusRuleRef($rule_name) {
        if ($BusRuleRef = BusRuleRef::where("rule_name", $rule_name)->first()) {
            return $BusRuleRef->rule_value;
        }
    }

    public function getAppInfo() {
        if ($BusRuleRef = BusRuleRef::select("rule_name", "rule_value")->whereIn("rule_name", array('ios_update_driver', 'android_update_driver', 'android_url_driver', 'ios_url_driver', 'ios_version_driver', 'android_version_driver', 'ios_update_user', 'android_update_user', 'android_url_user', 'ios_url_user', 'ios_version_user', 'android_version_user', 'app_update_msg'))->get()) {
            return $BusRuleRef;
        }
    }

    public function send_sms_forgot($number, $otp) {
        $apiKey         = urlencode('/tDnTktPlE4-X6mcUH5AHDxxloyjCy2DEgVXTvNdaO');
        $msg            = $otp . " is your verification OTP for forgot password into the LocalFineFoods app. Do not share this OTP with anyone.";
        // Message details
        $numbers        = array($number);
        $sender         = urlencode($this->getBusRuleRef("sms_sender_id"));
        $message        = rawurlencode($msg);

        $numbers        = implode(',', $numbers);

        // Prepare data for POST request
        $data           = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

        // Send the POST request with cURL
        $ch = curl_init('https://callsmsapi.com/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        // print_r($response);

        // Process your response here
        // echo $response;
        // die("-1-");
    }

    public function send_sms($number, $otp) {
        $apiKey = urlencode('/tDnTktPlE4-X6mcUH5AHDxxloyjCy2DEgVXTvNdaO');
        $msg = $otp . " is your verification OTP for registration into the LocalFineFoods app. Do not share this OTP with anyone.";
        // Message details
        $numbers = array($number);
        $sender = urlencode($this->getBusRuleRef("sms_sender_id"));
        $message = rawurlencode($msg);

        $numbers = implode(',', $numbers);

        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

        // Send the POST request with cURL
        $ch = curl_init('https://callsmsapi.com/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        // print_r($response);

        // Process your response here
        // echo $response;
        // die("-1-");
    }

    public function sendFirebaseNotification($user, $msgarray, $fcmData) {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $fcmApiKey = $this->getBusRuleRef("fcm_api_key");
        // echo "user";
        // echo "<pre>";
        // print_r($user);
        // echo "</pre>";
        // echo "\n";
        $fcmMsg = array(
            'title' => $msgarray['title'],
            'text' => $msgarray['msg'],
            'type' => $msgarray['type'],
            'vibrate' => 1,
            "date_time" => date("Y-m-d H:i:s"),
            'message' => $msgarray['msg'],
        );
        // echo "fcmMsg";
        // print_r($fcmMsg);
        // echo "\n";
        if ($user->device_type == "ios") {
            $fcmFields = array(
                'to' => $user->device_token,
                'priority' => 'high',
                'notification' => $fcmMsg,
                'data' => $fcmMsg,
            );
        } else {
            $fcmFields = array(
                'to' => $user->device_token,
                'priority' => 'high',
                'data' => $fcmMsg,
            );
        }
        // echo "fcmFields";
        // print_r($fcmFields);
        // echo "\n";

        $headers = array(
            'Authorization: key=' . $fcmApiKey,
            'Content-Type: application/json',
        );
        // print_r($driver->device_token);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
        $result = curl_exec($ch);
        //print_r($result);
        // print_r($user);
        if ($result === false) {
            // die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        // echo "\n##################################################################################################";
        // echo "\n\n\n";
        return $result;
    }

    public function sendBulkFirebaseNotification($user, $msgarray, $fcmData) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fcmApiKey = $this->getBusRuleRef("fcm_api_key");
        $fcmMsg = array(
            'title' => $msgarray['title'],
            'text' => $msgarray['msg'],
            'type' => $msgarray['type'],
            'vibrate' => 1,
            "date_time" => date("Y-m-d H:i:s"),
            'message' => $fcmData,
        );
        if ($user->device_type == "ios") {
            $fcmFields = array(
                'registration_ids' => $user->device_token,
                'priority' => 'high',
                'notification' => $fcmMsg,
                'data' => $fcmMsg,
            );
        } else {
            $fcmFields = array(
                'registration_ids' => $user->device_token,
                'priority' => 'high',
                'data' => $fcmMsg,
            );
        }
        $headers = array(
            'Authorization: key=' . $fcmApiKey,
            'Content-Type: application/json',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function sendTestNotification() {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fcmApiKey = $this->getBusRuleRef("fcm_api_key");
        $fcmMsg = array(
            'title' => "hello1",
            'text' => "hello2",
            'type' => "hello3",
            'vibrate' => 1,
            "date_time" => date("Y-m-d H:i:s"),
            'message' => "hello",
        );
        // if ($driver->device_type == "ios") {
        //     $fcmFields = array(
        //         'to' => "",
        //         'priority' => 'high',
        //         'notification' => "hi",
        //         'data' => "hello",
        //     );
        // } else {
        $fcmFields = array(
            'to' => "",
            'priority' => 'high',
            'data' => $fcmMsg,
        );
        // }

        $headers = array(
            'Authorization: key=' . $fcmApiKey,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
        $result = curl_exec($ch);
        print_r($result);
        echo "\n\n\n";
        if ($result === false) {
            // die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        return $result;
    }
    
    

    public function addErrorLogEntry($method_name, $error, $exception_error) {
        
        $id = DB::table('error_logs')->insertGetId(['error' => $error, 'method_name' => $method_name, 'exception_error' => $exception_error,'created_at'=>date("Y-m-d H:i:s")]);
        return $id;
    }
}
