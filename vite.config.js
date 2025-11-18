import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/status.css',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // allows LAN access
        port: 5173,
        strictPort: false,
    },
});
