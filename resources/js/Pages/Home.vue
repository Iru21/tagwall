<template>
    <Head title="Home" />
    <AppLayout>
        <div class="flex gap-4">
            <Card class="flex flex-col gap-4 w-1/4 h-fit"></Card>
            <InfiniteScroll class="w-full" data="posts">
                <Post v-for="post in posts.data" :key="post.id" :post="post" />
            </InfiniteScroll>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import {Head, InfiniteScroll} from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import {Post as PostType} from "@/types/global";
import Post from "@/components/Post.vue";
import Card from "@/components/Card.vue";

defineProps<{
    posts: {
        data: PostType[]
    }
}>()
</script>
