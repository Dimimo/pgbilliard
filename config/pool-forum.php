<?php

// Customize table names to your needs
return [
    'name_prefix' => 'forum.',
    'table_names' => [
        'posts'    => 'forum_posts',
        'tags'     => 'forum_tags',
        'comments' => 'forum_comments',
        'post_tag' => 'forum_post_tag',
    ],
    'models'      => [
        'user' => 'App\Models\User',
    ],
    'views'       => [
        'folder' => 'tw.',
    ],
    'roles'       => [
        'admin' => 'admin', //laravel-permissions Admin Role
    ],
];
