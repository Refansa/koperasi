import { resolvePageComponent } from 'vite-plugin-laravel/inertia';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { createApp, h } from 'vue';

// General Font
import 'vfonts/Lato.css';
// Monospace Font
import 'vfonts/FiraCode.css';

createInertiaApp({
    title: (title) => `Koperasi Maju Bersama - ${title}`,
    resolve: async (name) =>
        await resolvePageComponent(
            name,
            import.meta.glob('../views/pages/**/*.vue'),
            'default'
        ),
    setup({ el, app, props, plugin }) {
        createApp({ render: () => h(app, props) })
            .use(plugin)
            .mount(el);
    },
});

InertiaProgress.init({
    color: '#3DC187',
});
