<?php
return [
    'RESPONSE' => array(
        "status" => 500,
        "message" => "Internal server error",
        "data" => "",
    ),
    'MAIL_SENDER_ID'    => 'daghaner@yahoo.com',
    'CURRENCY'          => 'AUD',
    'CURRENCY_SYMBOL'   => '$',
    'FIRST_LANGUAGE'    => 'English',
    'SECOND_LANGUAGE'   => 'English',
    'RESET_PASSWORD_URL'=> 'http://yourdomain/reset-password?id=',
    'BOOKING_STATUS'    => [
        0 => 'declined', 
        1 => 'accepted', 
        2 => 'arrived', 
        3 => 'start_ride', 
        4 => 'cancelled', 
        5 => 'end_ride', 
        6 => 'schedule', 
        7 => 'finished', 
        8 => 'pending'
    ],
    'CONFIRM'               => [0 => 'No', 1 => 'Yes'],
    'STATUS'                => ['AC' => 'Active', 'IN' => 'Inactive', 'DL' => 'Delete', 'CM' => 'Complete', 'CL' => 'Cancelled', 'RD' => 'Read', 'PN'    => 'Pending'],
    'AMOUNT_TYPE'           => ['percent' => 'Percent', 'amount' => 'Amount'],
    'DISCOUNT_TYPE'         => ['normal' => 'Normal', 'rides' => 'Rides', 'usage' => 'Usage'],
    'UID' => [
        'bookings'          => 'BK', 
        'transactions'      => 'OD', 
        'booking_supports'  => 'BS', 
        'users'             => 'RF', 
        'referrer_users'    => 'REF',
        'orders'            => 'OD'
    ],
];