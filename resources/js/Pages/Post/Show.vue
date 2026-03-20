<template>
    <Head :title="post.title" />
    <AppLayout>
        <Card class="flex flex-col gap-4">
            <Alert kind="success" v-if="success">{{ success }}</Alert>
            <Switch radio undeselectable v-model="selectedMode"
                    :options="[{value: 'full', icon: RowsIcon}, {value: 'grid', icon: GridIcon}]" />
            <Viewer :images="images" :options="{
                transition: false, fullscreen: false, rotatable: false, scalable: false,
                movable: false
            }">
                <div :class="{
                    'flex flex-col gap-4': fullView,
                    'grid grid-cols-2 gap-4': !fullView
                }">
                    <div v-for="image in images" :key="image.path" class="w-full h-auto rounded-sm mb-4 relative">
                        <div v-if="image.is_nsfw" class="absolute top-0 left-0 size-full rounded-sm p-2
                         bg-black/50 backdrop-blur-lg grid place-items-center z-10">
                            <Card class="flex flex-col gap-4 max-w-lg">
                                <h2 class="text-2xl">NSFW / Sensitive</h2>
                                <p>This image is marked as NSFW. Click either button below to view it.
                                    You can change this setting <Link class="inline-flex!" :href="route('home')">here</Link>
                                    if you want to always see NSFW content.</p>
                                <div class="flex gap-4 self-end">
                                    <Button class="w-fit" kind="primary-dark" @click="unblur(image.id)">
                                        View Image
                                    </Button>
                                    <Button class="w-fit" kind="primary-dark" @click="unblurAll">
                                        View All Images
                                    </Button>
                                </div>
                            </Card>
                        </div>
                        <img :alt="image.alt"
                             :src="image.path" class="size-full object-cover rounded-sm"/>
                    </div>
                </div>
            </Viewer>
            <h1 class="mb-4">
                {{ post.title }}
            </h1>
        </Card>
    </AppLayout>
</template>
<script setup lang="ts">
import {Head, Link, usePage} from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import {Attachment, Post} from "@/types/global";
import Card from "@/components/Card.vue";
import {computed, ref} from "vue";
import Switch from "@/components/input/Switch.vue";
import GridIcon from "@/components/icons/GridIcon.vue";
import Alert from "@/components/Alert.vue";
import {component as Viewer} from "v-viewer";
import Button from "@/components/input/Button.vue";
import RowsIcon from "@/components/icons/RowsIcon.vue"

const props = defineProps<{
    post: Post
}>()

const images = ref<Attachment[]>(props.post.attachments?.filter(a => a.is_image) || [])

const unblur = (id: number) => {
    images.value = images.value.map(i => i.id === id ? {...i, is_nsfw: false} : i)
}

const unblurAll = () => {
    images.value = images.value.map(i => ({...i, is_nsfw: false}))
}

const selectedMode = ref<string[]>(['full'])
const fullView = computed(() => selectedMode.value.includes('full'))

const success = usePage().flash.success
</script>
