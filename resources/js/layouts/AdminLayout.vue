<template>
    <AppLayout>
        <div class="flex gap-4">
            <Card class="h-fit">
                <h2 class="mb-4 whitespace-nowrap">Admin Panel</h2>
                <nav>
                    <ul class="flex flex-col gap-4">
                        <li>
                            <Link :href="route('admin.users.index')">
                                <UserIcon/>
                                Users
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('admin.tags.index')">
                                <TagIcon />
                                Tags
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
import TagIcon from "@/components/icons/TagIcon.vue";
</script>
