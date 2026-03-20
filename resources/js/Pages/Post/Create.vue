<template>
    <Head title="Create Post" />
    <AppLayout>
        <Card class="flex flex-col gap-4">
            <h1>Create a post</h1>
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <label for="title">
                    <span>
                        Title<span class="text-error">*</span>
                    </span>
                    <input required v-model="form.title" id="title" name="title" type="text" placeholder="..."/>
                    <span v-if="form.errors.title" class="text-error">{{ form.errors.title }}</span>
                </label>
                <label for="post_content">
                    <span>
                        Content<span class="text-error">*</span>
                    </span>
                    <textarea required v-model="form.post_content" id="post_content" name="post_content" placeholder="..." rows="4"></textarea>
                    <span v-if="form.errors.post_content" class="text-error">{{ form.errors.post_content }}</span>
                </label>
                <label for="tags">
                    Tags
                    <TagSelect v-model="form.tags" />
                    <span v-if="form.errors.tags" class="text-error">{{ form.errors.tags }}</span>
                </label>
                <label for="attachments">
                    <span>
                        Attachments<span class="text-error">*</span>
                    </span>
                    <FileInput required v-model="form.attachments" id="attachments" name="attachments"/>
                    <span v-if="form.errors.attachments" class="text-error">{{ form.errors.attachments }}</span>
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
import {AttachedFile} from "@/types/global";

const form = useForm<{
    title: string,
    post_content: string,
    tags: string[]
    attachments: AttachedFile[],
}>({
    title: '',
    post_content: '',
    tags: [],
    attachments: [],
})

const submit = () => {
    form.post(route('posts.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        }
    })
}
</script>
