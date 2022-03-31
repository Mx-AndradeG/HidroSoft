require('./bootstrap');

import { createApp, h } from 'vue';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const inertiaApp = createApp({render: () => h(app, props)});
        inertiaApp.use(plugin);
        return inertiaApp.mount(el);
    },
});
