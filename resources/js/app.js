require('./bootstrap');

import {createApp, h} from "vue";
import {createInertiaApp, Link, Head} from "@inertiajs/inertia-vue3";
import {InertiaProgress} from "@inertiajs/progress";
import {ZiggyVue} from "ziggy";
import {Ziggy} from "./ziggy";
import alvue from '@myshell/alvue';
import VueFinalModal from 'vue-final-modal'
import TableLite from 'vue3-table-lite';
import Toast from "vue-toastification";
import VueGoogleMaps from '@fawmi/vue-google-maps';
import vSelect from 'vue-select';
import VScrollLock from 'v-scroll-lock';
import VueNumberInput from '@chenfengyuan/vue-number-input';
import printJS from 'print-js';

// Import the CSS or use your own!
import "vue-toastification/dist/index.css";
import 'vue-select/dist/vue-select.css';


InertiaProgress.init();

createInertiaApp({
    resolve: async (name) => {
        return (await import(`./Pages/${name}`)).default;
    },
    setup({el, App, props, plugin}) {
        const inertiaApp = createApp({render: () => h(App, props)});
        inertiaApp.use(plugin);
        inertiaApp.use(alvue);
        inertiaApp.use(VScrollLock);
        inertiaApp.use(Toast, {
            transition: "Vue-Toastification__bounce",
            maxToasts: 20,
            newestOnTop: true
        });
        inertiaApp.use(VueFinalModal());
        inertiaApp.component('TableLite', TableLite);
        inertiaApp.component('vSelect', vSelect);
        inertiaApp.component(VueNumberInput.name, VueNumberInput);
        inertiaApp.use(VueGoogleMaps, {
            load: {
                key: 'AIzaSyBNUQ6dexGtHrNYpKbJprtixL0czyKW5_M',
                libraries: "places"
            },
        }).mount('#inertiaApp')
        inertiaApp.mixin({methods: {route, $asset: (path) => (process.env.MIX_APP_URL + '/' + path),}});
        inertiaApp.mixin({ methods: {printJS } });
        return inertiaApp.mount(el);
    },
});

