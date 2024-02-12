<?php

// Customize table names to your needs
return [
    'name_prefix' => 'forum.',
    'table_names' => [
        'posts' => 'posts',
        'tags' => 'tags',
        'comments' => 'comments',
        'post_tag' => 'post_tag',
        'visits' => 'visits',
    ],
    'models' => [
        'user' => 'App\Models\User',
    ],
    'views' => [
        'folder' => 'tw.',
    ],
    'roles' => [
        'admin' => 'admin', //laravel-permissions Admin Role
    ],
];
