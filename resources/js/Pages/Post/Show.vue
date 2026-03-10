<template>
    <Head :title="post.title" />
    <AppLayout>
    </AppLayout>
</template>
<script setup lang="ts">
import {Head, usePage} from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import {Post} from "@/types/global";

const props = defineProps<{
    post: Post
}>()

console.log(props.post)

const success = usePage().flash.success
</script>
