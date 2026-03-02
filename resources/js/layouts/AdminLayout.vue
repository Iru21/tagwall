<template>
    <AppLayout>
        <div class="flex gap-4">
            <Card class="h-fit">
                <h2 class="mb-4">Admin Panel</h2>
                <nav>
                    <ul>
                        <li>
                            <Link :href="route('admin.users')">
                                <UserIcon/>
                                Users
                            </Link>
                        </li>
                    </ul>
                </nav>
            </Card>
            <div class="grow flex flex-col gap-4">
                <slot/>
            </div>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import Card from "@/components/Card.vue";
import {Link} from "@inertiajs/vue3";
import UserIcon from "@/components/icons/UserIcon.vue";
</script>
