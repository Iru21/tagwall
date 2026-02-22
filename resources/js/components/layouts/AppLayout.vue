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
                            <Link :href="route('home')">
                                Dashboard
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
import MainLayout from "@/components/layouts/MainLayout.vue";
import {Link, usePage} from "@inertiajs/vue3";

const authed = usePage().props.auth.user !== null;
</script>
