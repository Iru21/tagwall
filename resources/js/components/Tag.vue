<template>
    <component :is="href ? 'a' : 'span'" :href="href"
        class="bg-primary-500/20 text-primary-200 px-2 h-8 rounded-sm inline-flex items-center gap-1 select-none w-fit"
          :class="clickableClasses"
    >
        <TagIcon v-if="showTagIcon" class="size-4!"/>
        <slot/>
        {{ name }}
        <XIcon v-if="icon === 'x'" class="size-4!"/>
        <PlusIcon v-if="icon === 'plus'" class="size-4!"/>
    </component>
</template>
<script setup lang="ts">
import XIcon from "@/components/icons/XIcon.vue";
import PlusIcon from "@/components/icons/PlusIcon.vue";
import {computed} from "vue";
import TagIcon from "@/components/icons/TagIcon.vue";

const props = withDefaults(defineProps<{
    name: string,
    icon?: 'x' | 'plus',
    clickable?: boolean,
    href?: string,
    showTagIcon?: boolean,
}>(), {
    showTagIcon: true,
})

const clickableClasses = computed(() => {
    return !props.clickable ? '' : 'cursor-pointer hover:bg-primary-500/30 hover:text-primary-100'
})
</script>
