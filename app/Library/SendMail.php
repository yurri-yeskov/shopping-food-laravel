<?php
namespace App\Library;
use FCM;
use Mail;
use App\Model\BusRuleRef;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use PHPMailer\PHPMailer\PHPMailer;

class SendMail {

    public static function sendMails($view, $data, $subject) {
        $sender         = SendMail::getBusRuleRef('sender_id');
        $mail           = Mail::send($view, $data, function ($message) use ($data, $sender, $subject) {
            $message->to($data['email'], $data['first_name'] . " " . $data['last_name'])->subject($subject);
            $message->from($sender, 'Grocery App');
        });
        return $mail;
    }

    public static function sendmail($subject, $data, $file = null) {
        $mailData           = $data;
        $mail               = new PHPMailer(true);
        $mail->SMTPDebug    = 0;
        $mail->Host         = env('MAIL_HOST');
        $mail->IsSMTP();
        $mail->SMTPAuth     = true;
        $mail->Username     = env('MAIL_USERNAME');
        $mail->Password     = env('MAIL_PASSWORD');
        $mail->SMTPSecure   = env('MAIL_ENCRYPTION');
        $mail->Port         = env('MAIL_PORT');
        $mail->CharSet      = "UTF-8";
        $mail->setFrom('Grocery App');
        $mail->addAddress($data['email'], $data['user']);
        // $mail->addReplyTo($replyto, $replyto);
        $mail->isHTML(true);
        $mail->Subject      = $subject;
        $text = view('emails.reply_request', compact('mailData'));

        $mail->MsgHTML($text);

        return $mail->send();
    }

    public static function sendSMS($numbers, $msg) {
        // print_r($numbers);
        // print_r($msg);
        // $numbers should be array
        $apiKey         = urlencode(SendMail::getBusRuleRef("sms_key"));
        $sender         = urlencode(SendMail::getBusRuleRef("sms_sender_id"));
        $message        = rawurlencode($msg);
        $numbers        = implode(',', $numbers);
        $data           = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
        // echo "<pre>";
        // print_r($data);
        $ch = curl_init('https://smsapi.com/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response       = curl_exec($ch);
        print_r($response);
        curl_close($ch);
    }

    public static function sendWelcomeMail($subject, $data, $file = null, $email_view) {
        // $user = $data;
        $share_amount           = "50";
        $mail                   = new PHPMailer(true);
        $mail->SMTPDebug        = 0;
        $mail->Host             = env('MAIL_HOST');
        $mail->IsSMTP();
        $mail->SMTPAuth         = true;
        $mail->Username         = env('MAIL_USERNAME');
        $mail->Password         = env('MAIL_PASSWORD');
        $mail->SMTPSecure       = env('MAIL_ENCRYPTION');
        $mail->Port             = env('MAIL_PORT');
        $mail->CharSet          = "UTF-8";
        $mail->setFrom(env('MAIL_USERNAME'), env('APP_NAME'));
        $mail->addAddress($data->email, $data->name);
        // $mail->addReplyTo($replyto, $replyto);
        $mail->isHTML(true);
        $mail->Subject          = $subject;
        $text                   = view($email_view, compact('data', 'share_amount', 'password'));

        $mail->MsgHTML($text);

        return $mail->send();
    }
    public static function sendOrdercancelMail($subject, $data, $file = null, $email_view, $reason, $order_code = null) {

        $share_amount       = "50";
        $mail               = new PHPMailer(true);
        $mail->SMTPDebug    = 0;
        $mail->Host         = env('MAIL_HOST');
        $mail->IsSMTP();
        $mail->SMTPAuth     = true;
        $mail->Username     = env('MAIL_USERNAME');
        $mail->Password     = env('MAIL_PASSWORD');
        $mail->SMTPSecure   = env('MAIL_ENCRYPTION');
        $mail->Port         = env('MAIL_PORT');
        $mail->CharSet      = "UTF-8";
        $mail->setFrom(env('MAIL_USERNAME'), env('APP_NAME'));
        $mail->addAddress($data->email, $data->name);
        // $mail->addReplyTo($replyto, $replyto);
        $mail->isHTML(true);
        $mail->Subject      = $subject;
        $text = view($email_view, compact('data', 'reason', 'order_code'));

        $mail->MsgHTML($text);

        return $mail->send();
    }

    public static function sendUserInvoiceMail($subject, $data, $file = null, $email_view, $order, $cartdata) {
        //echo !extension_loaded('openssl')?"Not Available":"Available";
        //die;
        $share_amount       = "50";
        $mail               = new PHPMailer(true);
        $mail->SMTPDebug    = 0;
        $mail->Host         = env('MAIL_HOST');
        $mail->IsSMTP();
        $mail->SMTPAuth     = true;
        $mail->Username     = env('MAIL_USERNAME');
        $mail->Password     = env('MAIL_PASSWORD');
        $mail->SMTPSecure   = env('MAIL_ENCRYPTION');
        $mail->Port         = env('MAIL_PORT');
        $mail->CharSet      = "UTF-8";
        $mail->setFrom(env('MAIL_USERNAME'), env('APP_NAME'));
        $mail->addAddress($data->email, $data->name);
        // $mail->addReplyTo($replyto, $replyto);
        $mail->isHTML(true);
        $mail->Subject      = $subject;
        $text = view($email_view, compact('data', 'order', 'cartdata'));

        $mail->MsgHTML($text);
/*
$mail->send();
die;
 */
        return $mail->send();
    }

    public static function sendOrderMail($subject, $data, $file = null, $email_view, $order, $cartdata) {
        //echo !extension_loaded('openssl')?"Not Available":"Available";
        //die;
        $share_amount       = "50";
        $mail               = new PHPMailer(true);
        $mail->SMTPDebug    = 0;
        $mail->Host         = env('MAIL_HOST');
        $mail->IsSMTP();
        $mail->SMTPAuth     = true;
        $mail->Username     = env('MAIL_USERNAME');
        $mail->Password     = env('MAIL_PASSWORD');
        $mail->SMTPSecure   = env('MAIL_ENCRYPTION');
        $mail->Port         = env('MAIL_PORT');
        $mail->CharSet      = "UTF-8";
        $mail->setFrom(env('MAIL_USERNAME'), env('APP_NAME'));
        $mail->addAddress("info@managemybookings.net", "Grocery App");
        // $mail->addReplyTo($replyto, $replyto);
        $mail->isHTML(true);
        $mail->Subject      = $subject;
        $text = view($email_view, compact('data', 'order', 'cartdata'));

        $mail->MsgHTML($text);
/*
$mail->send();
die;
 */
        return $mail->send();
    }

    public static function sendDriverInvoiceMail($subject, $data, $file = null, $email_view, $email) {
        // $user = $data;
        $data               = (object) $data;
        $mail               = new PHPMailer(true);
        $mail->SMTPDebug    = 0;
        $mail->Host         = env('MAIL_HOST');
        $mail->IsSMTP();
        $mail->SMTPAuth     = true;
        $mail->Username     = env('MAIL_USERNAME');
        $mail->Password     = env('MAIL_PASSWORD');
        $mail->SMTPSecure   = env('MAIL_ENCRYPTION');
        $mail->Port         = env('MAIL_PORT');
        $mail->CharSet      = "UTF-8";
        $mail->setFrom(env('MAIL_USERNAME'), env('APP_NAME'));
        $mail->addAddress($email, $data->driver_name);
        // $mail->addReplyTo($replyto, $replyto);
        $mail->isHTML(true);
        $mail->Subject      = $subject;
        $text               = view($email_view, compact('data'));

        $mail->MsgHTML($text);

        return $mail->send();
    }

    public static function getBusRuleRef($rule_name) {
        if ($BusRuleRef = BusRuleRef::where("rule_name", $rule_name)->first()) {
            return $BusRuleRef->rule_value;
        }
    }
    public static function sendBulkNotifications($tokens, $notification) {

        $optionBuilder          = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);
        $notificationBuilder    = new PayloadNotificationBuilder($notification->title);
        $notificationBuilder->setBody($notification->description)
            ->setSound('default');
        $dataBuilder            = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);
        $option                 = $optionBuilder->build();
        $notification           = $notificationBuilder->build();
        $data                   = $dataBuilder->build();
        //$tokens = MYDATABASE::pluck('fcm_token')->toArray();
        $downstreamResponse     = FCM::sendTo($tokens, $option, $notification, $data);

        //print_r($downstreamResponse);
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

        //return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

        //return Array (key : oldToken, value : new token - you must change the token in your database )
        $downstreamResponse->tokensToModify();

        //return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

        // return Array (key:token, value:errror) - in production you should remove from your database the tokens present in this array
        $downstreamResponse->tokensWithError();
    }
}