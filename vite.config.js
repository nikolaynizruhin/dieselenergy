import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/admin/admin.scss',
                'resources/sass/app.scss',
                'resources/js/admin/admin.js',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
