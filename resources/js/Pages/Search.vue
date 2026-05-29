<template>
    <Head title="Search" />
    <AppLayout>
        <div class="flex flex-col gap-4">
            <h1>Search</h1>
            <Card>
                <form @submit.prevent="submit">
                    <label for="q">
                        Query
                        <input id="q" name="q" type="text" placeholder="..." v-model="form.q"/>
                        <span v-if="form.errors.q" class="text-error">{{ form.errors.q }}</span>
                    </label>
                    <label for="tags">
                        Tags
                        <TagSelect name="tags" v-model="form.tags" only-existing />
                        <span v-if="form.errors.tags" class="text-error">{{ form.errors.tags }}</span>
                    </label>
                    <Button class="w-fit self-end" kind="primary" :loading="form.processing" type="submit">Search</Button>
                </form>
            </Card>
        </div>
    </AppLayout>
</template>
<script setup lang="ts">

import AppLayout from "@/layouts/AppLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import Card from "@/components/Card.vue";
import TagSelect from "@/components/input/TagSelect.vue";
import Button from "@/components/input/Button.vue";

const form = useForm<{
    q: string,
    tags: string[]
}>()

const submit = () => {
    form.get(route('search'), {
        preserveScroll: true,
    })
}
</script>
