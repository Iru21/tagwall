import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import {createApp, DefineComponent, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";
import {ZiggyVue} from "ziggy-js"

import 'viewerjs/dist/viewer.css'
import VueViewer from 'v-viewer'

import {useTheme} from './composables/useTheme';
useTheme().initTheme();

import {createPinia} from "pinia";
const pinia = createPinia()

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Tagwall';
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(pinia)
            .use(ZiggyVue)
            .use(VueViewer)
            .mount(el)
    },
    progress: {
        color: 'var(--color-primary-400)',
        showSpinner: true
    },
    defaults: {
        future: {
            useDialogForErrorModal: true,
        }
    }
})
