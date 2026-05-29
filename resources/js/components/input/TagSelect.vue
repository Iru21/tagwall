<template>
    <div class="flex flex-col bg-background border border-border rounded-xs">
        <div class="flex">
            <div class="flex flex-wrap gap-2 px-3 py-2 w-full" @click.stop="toggleShow">
                <Tag v-if="selectedTags.length" v-for="tag in selectedTags" :key="tag" :name="tag" icon="x"
                     clickable @click.stop="removeTag(tag)" />
                <span v-else class="text-muted-600">No tags selected</span>
            </div>
            <Button type="button" kind="primary-dark" @click="toggleShow">
                <XIcon v-if="show" class="size-4!"/>
                <ChevronDownIcon v-else class="size-4!"/>
            </Button>
        </div>
        <div v-if="show" class="flex flex-col w-full">
            <div class="flex items-center w-full gap-2">
                <input ref="tagSearch" type="text" placeholder="Search or add a new tag" class="w-full border-none focus:ring-0!"
                       @keydown.enter.prevent="addNewTag" @input="search"/>
                <Button type="button" kind="primary-dark" size="sm" @click.stop="addNewTag"
                        v-if="tagSearch?.value && !selectedTags.includes(tagSearch?.value || '') && (!onlyExisting || foundTags.includes(tagSearch?.value || ''))">
                    <PlusIcon class="size-4!"/>
                </Button>
            </div>
            <div class="flex flex-wrap gap-2 px-3 py-2" v-if="foundTags.length">
                <Tag v-for="tag in foundTags" :key="tag" :name="tag" icon="plus" clickable @click.stop="addTag(tag)"/>
                <span v-if="!tagSearch?.value" class="text-muted-400 self-end">...</span>
            </div>
            <span v-if="tagSearch?.value" class="text-muted-400 px-3 py-2">
                <template v-if="onlyExisting">
                    Select existing tags
                </template>
                <template v-else>
                    Press enter or click the plus button to add a new tag
                </template>
            </span>
        </div>
    </div>
</template>
<script setup lang="ts">
import {nextTick, ref, useTemplateRef, watch} from "vue";
import axios from "axios";
import Tag from "@/components/Tag.vue";
import Button from "@/components/input/Button.vue";
import XIcon from "@/components/icons/XIcon.vue";
import ChevronDownIcon from "@/components/icons/ChevronDownIcon.vue";
import PlusIcon from "@/components/icons/PlusIcon.vue";

const props = withDefaults(defineProps<{
    onlyExisting?: boolean
}>(), {
    onlyExisting: false,
})

const show = ref(false);
const tagSearch = useTemplateRef('tagSearch')
const toggleShow = () => {
    show.value = !show.value
    if (show.value) {
        search()
        nextTick(() => tagSearch.value?.focus())
    } else {
        foundTags.value = []
    }
}
const model = defineModel<string[]>()

const selectedTags = ref<string[]>(model.value || [])
const foundTags = ref<string[]>([])

const search = () => {
    axios.get(route('tags.index', {search: tagSearch.value?.value})).then(res => {
        foundTags.value = res.data.map((tag: {name: string}) => tag.name).filter((tag: string) => !selectedTags.value.includes(tag))
    })
}

const addNewTag = () => {
    if(!tagSearch.value) return
    const tag = tagSearch.value.value
    if (!tag) return
    if(selectedTags.value.includes(tag)) return
    if(props.onlyExisting && !foundTags.value.includes(tag)) return
    addTag(tag)
    tagSearch.value.value = ''
    search()
}

const addTag = (tag: string) => {
    selectedTags.value.push(tag)
}

const removeTag = (tag: string) => {
    selectedTags.value = selectedTags.value.filter(t => t !== tag)
    if(show.value) {
        search()
    }
}


watch(
    () => selectedTags.value,
    () => {
        foundTags.value = foundTags.value.filter(tag => !selectedTags.value.includes(tag))
        model.value = selectedTags.value
    },
    {deep: true}
)

</script>
