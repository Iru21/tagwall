import {AxiosInstance} from 'axios';
import {route as ZiggyRoute, Config as ZiggyConfig} from 'ziggy-js';

declare global {
    interface Window {
        axios: AxiosInstance;
        Ziggy: ZiggyConfig
    }

    let route: typeof ZiggyRoute;
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ZiggyRoute;
    }
}

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: {
            auth: { user: { id: number; username: string, is_admin: bool, activated_at: Date } | null };
        };
        flashDataType: {
            success: string | null;
        }
    }
}
