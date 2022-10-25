import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { resolvePageComponent } from "vite-plugin-laravel/inertia";
import { InertiaProgress } from "@inertiajs/progress";

// General Font
import "vfonts/Lato.css";
// Monospace Font
import "vfonts/FiraCode.css";

createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(name, import.meta.glob("../views/pages/**/*.vue")),
    setup({ el, app, props, plugin }) {
        createApp({ render: () => h(app, props) })
            .use(plugin)
            .mount(el);
    },
});

InertiaProgress.init({ color: "#63E2B7" });
