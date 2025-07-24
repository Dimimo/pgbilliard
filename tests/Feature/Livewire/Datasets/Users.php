<?php

dataset('users', [
    fn () => \App\Models\User::factory()->create(['name' => 'user 1', 'email' => 'user1@email.com', 'password' => bcrypt('secret')]),
    fn () => \App\Models\User::factory()->create(['name' => 'user 2', 'email' => 'user2@email.com', 'password' => bcrypt('secret')]),
    fn () => \App\Models\User::factory()->create(['name' => 'user 3', 'email' => 'user3@email.com', 'password' => bcrypt('secret')]),
]);
