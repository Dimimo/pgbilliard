import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import preload from "vite-plugin-preload";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/ably.js',
            ],
            refresh: [
                'resources/views/**',
                'app/Livewire/**',
                'storage/framework/views/**',
            ],
            detectTls: 'pgbilliard.test',
        }),
        preload(),
    ],
});
