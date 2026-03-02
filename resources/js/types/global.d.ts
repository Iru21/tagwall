import {AxiosInstance} from 'axios';
import {route as ZiggyRoute, Config as ZiggyConfig} from 'ziggy-js';

interface User {
    id: number;
    username: string,
    is_admin: bool,
    activated_at: string | null,
    created_at: string,
    updated_at: string,
}

interface Paginated<T> {
    data: T[];
    total: number;
    per_page: number;
    current_page: number;
    last_page: number;
    from: number;
    to: number;
    path: string;
    next_page_url: string | null;
    prev_page_url: string | null;
    first_page_url: string;
    last_page_url: string;
}

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
            auth: { user: User | null };
        };
        flashDataType: {
            success: string | null;
        }
    }
}
