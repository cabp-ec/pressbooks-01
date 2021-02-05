<?php

return [
    /* Application Name */
    'name' => env('APP_NAME', 'Books API'),

    /* Application Environment */
    'env' => env('APP_ENV', 'production'),

    /* Application Debug Mode */
    'debug' => env('APP_DEBUG', true),

    /* Application URL */
    'url' => env('APP_URL', 'http://pressbooks.local'),

    /* Application Timezone */
    'timezone' => 'UTC',

    /* Application Locale Configuration */
    'locale' => 'en',

    /* Application Fallback Locale */
    'fallback_locale' => 'en',

    /* Encryption Key */
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
];
