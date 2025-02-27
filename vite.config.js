import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        https: mode === 'production', // Activa HTTPS solo en producción
        host: '0.0.0.0', // Asegura que se escuche en todos los hosts
        port: 5173
    },
    
});
