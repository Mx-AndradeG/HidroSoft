require('./bootstrap');

import { createApp, h } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { ZiggyVue } from "ziggy";
import { Ziggy } from "./ziggy";
import alvue from '@myshell/alvue';
import VueFinalModal from 'vue-final-modal'
import TableLite from 'vue3-table-lite';


InertiaProgress.init();

createInertiaApp({
    resolve: async (name) => {
        return (await import(`./Pages/${name}`)).default;
    },
    setup({ el, App, props, plugin }) {
        const inertiaApp = createApp({render: () => h(App, props)});
        inertiaApp.use(plugin);
        inertiaApp.use(alvue);
        inertiaApp.use(VueFinalModal());
        inertiaApp.component('TableLite', TableLite);
        inertiaApp.mixin({ methods: { route } });
        return inertiaApp.mount(el);
    },
});
