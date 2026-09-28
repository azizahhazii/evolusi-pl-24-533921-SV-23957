<?php

/*
 * CORS: browser hanya mengizinkan halaman dari origin lain (mis. Vue di
 * localhost:5173) memanggil Laravel bila Laravel mengizinkannya.
 * Daftar origin bisa diganti lewat CORS_ALLOWED_ORIGINS di .env (pisahkan dengan koma).
 */
return [
    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => array_values(array_filter(array_map(
        'trim',
        explode(',', env('CORS_ALLOWED_ORIGINS', 'http://localhost:5173,http://127.0.0.1:5173'))
    ))),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];
