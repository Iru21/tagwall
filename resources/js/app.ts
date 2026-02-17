import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import {createApp, DefineComponent, h} from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";
import {ZiggyVue, Config as ZiggyConfig} from "ziggy-js";
import {Ziggy} from "./ziggy";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Tagwall';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy as ZiggyConfig)
            .mount(el)
    },
})
