import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    server: {
        host: true,
        strictPort: true,
        port: 5173,
        hmr: {
            host: 'nonulcerous-despairful-lesli.ngrok-free.dev',
            protocol: 'wss',
            port: 443,
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/cart.css'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
