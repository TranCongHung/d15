import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/admin.css', 'resources/js/admin.js'],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            // Bảo Vite không đóng gói gói này, nó sẽ được trình duyệt xử lý qua importmap
            external: ['@google/genai'],
        },
    },
});