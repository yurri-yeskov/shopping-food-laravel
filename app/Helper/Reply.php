<?php

    namespace App\Helper;

    use Illuminate\Contracts\Validation\Validator;

    class Reply
    {

        public static function success($message) {
            return [
                "status" => "success",
                "message" => Reply::getTranslated($message)
            ];
        }

        public static function successWithData($message, $data) {
            $response = Reply::success($message);

            return array_merge($response, $data);
        }

        public static function error($message, $error_name = null, $errorData = []) {
            return [
                "status" => "fail",
                "error_name" => $error_name,
                "data" => $errorData,
                "message" => Reply::getTranslated($message)
            ];
        }

        public static function formErrors($validator) {
            return [
                "status" => "fail",
                "errors" => $validator->getMessageBag()->toArray()
            ];
        }

        public static function redirect($url, $message = null) {
            if ($message) {
                return [
                    "status" => "success",
                    "message" => Reply::getTranslated($message),
                    "action" => "redirect",
                    "url" => $url
                ];
            }
            else {
                return [
                    "status" => "success",
                    "action" => "redirect",
                    "url" => $url
                ];
            }
        }

        private static function getTranslated($message) {
            $trans = trans($message);

            if ($trans == $message) {
                return $message;
            }
            else {
                return $trans;
            }
        }


        public static function dataOnly($data) {
            return $data;
        }

    }