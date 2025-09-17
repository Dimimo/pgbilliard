<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Would you like the installation button to appear on all pages?
      Set true/false
    |--------------------------------------------------------------------------
    */

    'install-button' => true,

    /*
    |--------------------------------------------------------------------------
    | PWA Manifest Configuration
    |--------------------------------------------------------------------------
    |  php artisan erag =>update-manifest
    */

    'manifest' => [
        'name' => 'Puerto Galera Billiard League',
        'short_name' => 'PG billiard',
        'background_color' => '#fafafa',
        'display' => 'fullscreen',
        'orientation' => 'any',
        'start_url' => 'https://www.pgparrot.com',
        'description' => 'The official app of the Puerto Galera Billiard League. View live scores, match schedules, team standings, and results. The app is a convenient way for players and fans to follow the competition.',
        'theme_color' => '#0cc716',
        'icons' => [
            [
                '36x36' => public_path('android-icon-36x36.png'),
                '48x48' => public_path('android-icon-48x48.png'),
                '72x72' => public_path('android-icon-72x72.png'),
                '96x96' => public_path('android-icon-96x96.png'),
                '128x128' => public_path('android-icon-128x128.png'),
                '144x144' => public_path('android-icon-144x144.png'),
                '192x192' => public_path('android-icon-192x192.png'),
                '384x384' => public_path('android-icon-384x384.png'),
                '512x512' => public_path('android-icon-512x512.png'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Debug Configuration
    |--------------------------------------------------------------------------
    | Toggles the application's debug mode based on the environment variable
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Livewire Integration
    |--------------------------------------------------------------------------
    | Set to true if you're using Livewire in your application to enable
    | Livewire-specific PWA optimizations or features.
    */

    'livewire-app' => true,
];
