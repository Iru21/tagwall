<template>
    <MainLayout>
        <template #header>
            <nav class="flex items-center justify-between">
                <Link :href="route('home')" class="text-2xl tracking-[0.2em]">
                    Tagwall
                </Link>
                <ul class="ml-auto flex gap-4">
                    <template v-if="authed">
                        <li>
                            <Link title="Dashboard" :href="route('home')">
                                <UserIcon />
                            </Link>
                        </li>
                        <li v-if="is_admin">
                            <Link title="Admin Panel" :href="route('admin.index')">
                                <CogIcon />
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('logout')">
                                <LogoutIcon />
                            </Link>
                        </li>
                    </template>
                    <template v-else>
                        <li>
                            <Link :href="route('login')">
                                Login
                            </Link>
                            <Link :href="route('register')">
                                Register
                            </Link>
                        </li>
                    </template>
                </ul>
            </nav>
        </template>
        <slot/>
    </MainLayout>
</template>
<script setup lang="ts">
import MainLayout from "@/layouts/MainLayout.vue";
import {Link, usePage} from "@inertiajs/vue3";
import CogIcon from "@/components/icons/CogIcon.vue";
import UserIcon from "@/components/icons/UserIcon.vue";
import LogoutIcon from "@/components/icons/LogoutIcon.vue";

const user = usePage().props.auth.user
const authed = user !== null
const is_admin = user?.is_admin
</script>
