import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';

const host = 'app.cmhrc.local';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host,
        hmr: { host },
        https: {
            key: fs.readFileSync(`/etc/ssl/private/nginx-selfsigned.key`),
            cert: fs.readFileSync(`/etc/ssl/certs/nginx-selfsigned.crt`),
        },
    },
});
