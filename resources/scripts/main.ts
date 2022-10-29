import { resolvePageComponent } from "vite-plugin-laravel/inertia";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";

import {
    createApp,
    h,
} from "vue";

import { useTheme } from "./composables/theme";

// General Font
import "vfonts/Lato.css";
// Monospace Font
import "vfonts/FiraCode.css";

createInertiaApp({
    title: (title) => `Koperasi - ${title}`,
    resolve: (name) =>
        resolvePageComponent(name, import.meta.glob("../views/pages/**/*.vue"), 'default'),
    setup({ el, app, props, plugin }) {
        createApp({ render: () => h(app, props) })
            .use(plugin)
            .mount(el);
    },
});

InertiaProgress.init({ color: useTheme().value.name === 'light' ? '#18A058' : '#63E2B7' });
