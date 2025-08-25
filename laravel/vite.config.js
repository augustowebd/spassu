import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/authors/create.js',
                'resources/js/authors/grid.js',
                'resources/js/books/create.js',
                'resources/js/books/grid.js',
                'resources/js/subjects/create.js',
                'resources/js/subjects/grid.js',
                'resources/js/font-size.js',
                'resources/js/showToast.js',
                'resources/js/switch-theme.js',

                'resources/css/app.css',
                'resources/sass/app.scss',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
