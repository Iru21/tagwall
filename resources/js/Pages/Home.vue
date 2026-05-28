<template>
    <Head title="Home" />
    <AppLayout>
        <div class="flex gap-4">
            <InfiniteScroll v-if="posts.data.length" class="w-full" data="posts">
                <Post v-for="post in posts.data" :key="post.id" :post="post" />
            </InfiniteScroll>
            <p v-else class="w-full text-center text-muted-300">No posts yet.</p>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">
import {Head, InfiniteScroll} from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import {Post as PostType} from "@/types/global";
import Post from "@/components/Post.vue";

defineProps<{
    posts: {
        data: PostType[]
    }
}>()
</script>
