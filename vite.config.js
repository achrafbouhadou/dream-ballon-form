import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            // Set refresh to false for production
            refresh: false,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: '', // Set an empty string for production
                },
            },
        }),
    ],
    // Set the base URL for production
    base: 'https://dream-form.online/', // Update with your actual domain
    // Add other production-specific configurations if needed
});
