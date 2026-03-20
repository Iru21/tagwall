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

interface Post {
    id: number;
    user_id: number,
    user?: User,
    title: string,
    content: string,
    attachments?: Attachment[],
    tags?: Tag[],
    created_at: string,
    updated_at: string,
}

interface Attachment {
    id: number;
    path: string,
    alt: string,
    is_nsfw: boolean,
    is_image: bool,
    created_at: string,
    updated_at: string,
}

interface AttachedFile {
    file: File,
    alt: string,
    is_nsfw: boolean,
}

interface Tag {
    id: number;
    name: string,
    created_at: string,
    updated_at: string,
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
