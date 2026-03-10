<template>
    <Head title="Create Post" />
    <AppLayout>
        <Card class="flex flex-col gap-4">
            <h1>Create a post</h1>
            <form @submit.prevent="submit">
                <label for="title">
                    <span>
                        Title<span class="text-error">*</span>
                    </span>
                    <input required v-model="form.title" id="title" name="title" type="text" placeholder="..."/>
                </label>
                <label for="content">
                    <span>
                        Content<span class="text-error">*</span>
                    </span>
                    <textarea required v-model="form.content" id="content" name="content" placeholder="..." rows="4"></textarea>
                </label>
                <label for="tags">
                    Tags
                    <TagSelect v-model="form.tags" />
                </label>
                <label for="attachments">
                    <span>
                        Attachments<span class="text-error">*</span>
                    </span>
                    <FileInput required v-model="form.attachments" id="attachments" name="attachments" />
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
import FileInput from "@/components/input/FileInput.vue";

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
    console.log({...form})
}
</script>
