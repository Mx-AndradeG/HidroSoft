require('./bootstrap');

import { createApp, h } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { ZiggyVue } from "ziggy";
import { Ziggy } from "./ziggy";
import alvue from '@myshell/alvue';
import TableLite from 'vue3-table-lite';
import Toast from "vue-toastification";

// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

InertiaProgress.init();

createInertiaApp({
    resolve: async (name) => {
        return (await import(`./Pages/${name}`)).default;
    },
    setup({ el, App, props, plugin }) {
        const inertiaApp = createApp({render: () => h(App, props)});
        inertiaApp.use(plugin);
        inertiaApp.use(alvue);
        inertiaApp.use(Toast, {
            transition: "Vue-Toastification__bounce",
            maxToasts: 20,
            newestOnTop: true
          });
        inertiaApp.component('TableLite', TableLite);
        inertiaApp.mixin({ methods: { route } });
        return inertiaApp.mount(el);
    },
});