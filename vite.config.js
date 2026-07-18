import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');

    // Bind on all interfaces inside Docker; browser must use a host it can reach.
    // VITE_HMR_HOST defaults to localhost (host machine / published port).
    const hmrHost = env.VITE_HMR_HOST || 'localhost';
    const port = Number(env.VITE_PORT || 5173);

    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
        ],
        server: {
            host: '0.0.0.0',
            port,
            strictPort: true,
            origin: env.VITE_DEV_SERVER_URL || `http://${hmrHost}:${port}`,
            cors: true,
            hmr: {
                host: hmrHost,
                port,
            },
            watch: {
                // Reliable file watching with Docker bind mounts
                usePolling: env.VITE_USE_POLLING === 'true' || env.VITE_USE_POLLING === '1',
            },
        },
    };
});
