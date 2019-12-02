<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Api Key
      |--------------------------------------------------------------------------
      |
      | The pushy API secret key. You can find it or create a new one in the
      | API authentication tab of the application section in the Pushy dashboard
      | https://dashboard.pushy.me/apps/<YOUR_APP_ID>/auth
     */
    'api_key' => env('PUSHY_API_KEY'),
    /*
      |--------------------------------------------------------------------------
      | Is Channel Active
      |--------------------------------------------------------------------------
      |
      | Activates or deactivates the Pushy channel.
     */
    'is_channel_active' => (bool) env('PUSHY_CHANNEL_ACTIVE', true),
    /*
      |--------------------------------------------------------------------------
      | Request Retries
      |--------------------------------------------------------------------------
      |
      | Specifies the number of retries when receiving a 500 error response.
     */
    'request_retries' => env('PUSHY_REQUEST_RETRIES', 3),
    /*
      |--------------------------------------------------------------------------
      | Time To Live
      |--------------------------------------------------------------------------
      |
      | Specifies the default ttl for a pending notificacion.
     */
    'time_to_live' => env('PUSHY_NOTIFICATION_TTL', 2592000),
];
