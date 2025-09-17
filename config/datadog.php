<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Datadog Configuration
    |--------------------------------------------------------------------------
    */
    
    'api_key' => env('DD_API_KEY'),
    'app_key' => env('DD_APP_KEY'),
    'site' => env('DD_SITE', 'datadoghq.com'),
    
    'service' => env('DD_SERVICE', 'laravel-app'),
    'env' => env('DD_ENV', 'production'),
    'version' => env('DD_VERSION', '1.0.0'),
    
    'trace' => [
        'enabled' => env('DD_TRACE_ENABLED', true),
    ],
    
    'logs' => [
        'injection' => env('DD_LOGS_INJECTION', true),
    ],
    
    'dogstatsd' => [
        'host' => env('DD_DOGSTATSD_HOST', 'localhost'),
        'port' => env('DD_DOGSTATSD_PORT', 8125),
    ],
    
    'apm' => [
        'enabled' => env('DD_APM_ENABLED', true),
    ],
];
