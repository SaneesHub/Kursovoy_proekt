import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',    // Главный CSS-файл
                'resources/js/app.js',      // Главный JS-файл
            ],
            refresh: true,
        }),
    ],
});