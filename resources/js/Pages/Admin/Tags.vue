<template>
    <Head title="Tags - Admin Panel"/>
    <AdminLayout>
        <Card class="flex flex-col gap-4 mb-15">
            <h2>Tags</h2>
            <Alert v-if="error" kind="error">
                {{ error }}
            </Alert>
            <div class="flex gap-4">
                <Form ref="filterFormRef" :action="route('admin.tags.index')" method="get" class="flex-row! w-full"
                      #default="{ processing }" :options="{ preserveState: true, preserveScroll: true }">
                    <label for="sort">
                        Sort by
                        <select id="sort" name="sort" v-model="filters.sort">
                            <option value="name">Name</option>
                            <option value="created_at" selected>Created</option>
                        </select>
                    </label>
                    <label for="order">
                        Order
                        <select id="order" name="order" v-model="filters.order">
                            <option value="asc">Ascending</option>
                            <option value="desc" selected>Descending</option>
                        </select>
                    </label>
                    <Button :loading="processing" kind="primary" class="h-fit self-end" type="submit">Filter</Button>
                </Form>
            </div>
            <InfiniteScroll data="tags" :buffer="200" class="flex flex-col gap-2">
                <Tag v-for="tag in tags.data" :key="tag.id" icon="x" clickable
                     :name="`${tag.name} (${new Date(tag.created_at).toLocaleString('uk')})`" @click="deleteTag(tag.id)"/>
            </InfiniteScroll>
        </Card>
    </AdminLayout>
</template>
<script setup lang="ts">
import AdminLayout from "@/layouts/AdminLayout.vue";
import Card from "@/components/Card.vue";
import {Head, router, InfiniteScroll, Form} from "@inertiajs/vue3";
import Button from "@/components/input/Button.vue";
import {ref} from "vue";
import Alert from "@/components/Alert.vue";
import {Tag as TagType} from "@/types/global";
import Tag from "@/components/Tag.vue";

const props = defineProps<{
    tags: {
        data: TagType[],
    },
    filters: {
        order: string,
        sort: string
    }
}>()

const filters = ref(props.filters)

const error = ref<string | null>(null)

const deleteTag = (id: number) => {
    router.delete(route('admin.tags.destroy', id), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            error.value = null
        },
        onError: (errors) => {
            error.value = errors.error
        }
    })
}
</script>
