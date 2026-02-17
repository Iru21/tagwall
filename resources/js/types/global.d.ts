import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { AxiosInstance } from 'axios';
import { route as ZiggyRoute, Config as ZiggyConfig } from 'ziggy-js';
import { PageProps as AppPageProps } from './';

declare global {
    interface Window {
        axios: AxiosInstance;
        Ziggy: ZiggyConfig
    }

    let route: typeof ZiggyRoute;
}

declare module 'ziggy-js' {
    interface RouteList {
        "storage.local": [
            {
                "name": "path",
                "required": true
            }
        ],
        "storage.local.upload": [
            {
                "name": "path",
                "required": true
            }
        ]
    }
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ZiggyRoute;
    }
}

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}
