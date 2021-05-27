<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAq3Kgv48:APA91bGmO3mcl4k1s7g1x6BrQVhj8sxv3iV6WKtNFmYyTo_uwotbAI-0xJvx-bElAPtV7A_WkTg-nmCYMG5T-A06MUIDC8__p4xvFDjjs1pBK35Dvf7u9mM9PjV-J2DkUM9X8FEoQCLz'),
        'sender_id' => env('FCM_SENDER_ID', '736362545039'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
