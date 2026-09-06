<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Track API Credentials
    |--------------------------------------------------------------------------
    |
    | Used for Basic Auth against the Track API (customer profiles, events).
    | Find them under Settings > Account Settings > API Credentials.
    |
    */
    'site_id' => env('CUSTOMERIO_SITE_ID', ''),
    'api_key' => env('CUSTOMERIO_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | App API Key
    |--------------------------------------------------------------------------
    |
    | Used as a Bearer token against the App API (campaigns, transactional
    | messaging). Create one under Settings > API Credentials > App API Keys.
    |
    */
    'app_key' => env('CUSTOMERIO_APP_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Base URLs
    |--------------------------------------------------------------------------
    |
    | Overridable in case Customer.io ever changes hosts or you need to point
    | at a region-specific endpoint (e.g. EU workspaces).
    |
    */
    'track_url' => env('CUSTOMERIO_TRACK_URL', 'https://track.customer.io/api/v1'),
    'app_url' => env('CUSTOMERIO_APP_URL', 'https://api.customer.io/v1'),

];
