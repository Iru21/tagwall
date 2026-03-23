<template>
    <div>
        <Link ref="link" class="hidden" :href="route('posts.show', post.id)"/>
        <Card @click="click" class="cursor-pointer hover:bg-primary-200/10 flex flex-col gap-2">
            <div class="grid grid-cols-2 gap-2">
                <div v-for="image in images" :key="image.path" class="w-full h-100 rounded-sm mb-4 relative"
                    :class="{
                        'col-span-2': images.length === 1,
                        'row-span-2': images.length === 2 || images.length === 3 && images.indexOf(image) === 2,
                    }"
                >
                    <div v-if="image.is_nsfw" class="absolute top-0 left-0 size-full rounded-sm p-2
                         bg-black/50 backdrop-blur-lg grid place-items-center z-10">
                    </div>
                    <img :alt="image.alt"
                         :src="image.path" class="size-full object-cover rounded-sm"/>
                </div>
            </div>
            <div class="flex gap-2 items-end">
                <h3>{{ post.title }}</h3>
                <span class="text-muted-300">{{ post.created_at }}</span>
            </div>
        </Card>
    </div>
</template>
<script setup lang="ts">
import Card from "@/components/Card.vue";
import {Attachment, Post} from "@/types/global";
import {Link} from "@inertiajs/vue3";
import {ref, useTemplateRef} from "vue";
import {NSFWDisplay, useSettingsStore} from "@/stores/settings";

const props = defineProps<{
    post: Post
}>()

const { settings } = useSettingsStore()
const images = ref<Attachment[]>(props.post.attachments?.filter(a => a.is_image) || [])
if(settings.nsfw_display === NSFWDisplay.HIDE) {
    images.value = images.value.filter(i => !i.is_nsfw)
} else if (settings.nsfw_display === NSFWDisplay.ALWAYS) {
    images.value = images.value.map(i => ({...i, is_nsfw: false}))
}
images.value = images.value.slice(0, 4)

const link = useTemplateRef('link')

const click = () => {
    link.value!.$el.click()
}
</script>
