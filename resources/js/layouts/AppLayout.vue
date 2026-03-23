<template>
    <MainLayout>
        <template #header>
            <nav class="flex items-center justify-between">
                <Link :href="route('home')" class="text-2xl tracking-[0.2em]">
                    Tagwall
                </Link>
                <ul class="ml-auto flex gap-4 items-center">
                    <template v-if="authed">
                        <li>
                            <Button kind="primary" size="sm" as="a" :href="route('posts.create')">
                                <template #icon>
                                    <PlusIcon />
                                </template>
                                Add a post
                            </Button>
                        </li>
                        <li>
                            <Link title="Dashboard" :href="route('home')">
                                <UserIcon />
                            </Link>
                        </li><li>
                            <Link title="Calendar View" :href="route('home')">
                                <CalendarIcon />
                            </Link>
                        </li>
                        <li>
                            <Link title="Settings" :href="route('settings.index')">
                                <CogIcon />
                            </Link>
                        </li>
                        <li v-if="is_admin">
                            <Link title="Admin Panel" :href="route('admin.index')">
                                <TerminalIcon />
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
                            <Link title="Settings" :href="route('settings.index')">
                                <CogIcon />
                            </Link>
                        </li>
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
import Button from "@/components/input/Button.vue";
import PlusIcon from "@/components/icons/PlusIcon.vue";
import TerminalIcon from "@/components/icons/TerminalIcon.vue";
import CalendarIcon from "@/components/icons/CalendarIcon.vue";

const user = usePage().props.auth.user
const authed = user !== null
const is_admin = user?.is_admin
</script>
