<template>
    <Head title="Create Post" />
    <AppLayout>
        <Card class="flex flex-col gap-4">
            <h1>Create a post</h1>
            <form @submit.prevent="submit">
                <label for="title">
                    Title
                    <input required v-model="form.title" id="title" name="title" type="text" placeholder="..."/>
                </label>
                <label for="content">
                    Content
                    <textarea required v-model="form.content" id="content" name="content" placeholder="..." rows="4"></textarea>
                </label>
                <label for="tags">
                    Tags
                    <TagSelect v-model="form.tags" />
                </label>
                <Button class="w-fit ml-auto" kind="primary" type="submit">Submit</Button>
            </form>
        </Card>
    </AppLayout>
</template>
<script setup lang="ts">
import {Head, useForm} from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import Card from "@/components/Card.vue";
import Button from "@/components/input/Button.vue";
import TagSelect from "@/components/input/TagSelect.vue";

const form = useForm<{
    title: string,
    content: string,
    tags: string[]
    attachments: File[]
}>({
    title: '',
    content: '',
    tags: [],
    attachments: [],
})

const submit = () => {
}
</script>
