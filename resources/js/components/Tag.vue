<template>
    <component :is="href ? 'a' : 'span'" :href="href"
        class="bg-primary-500/20 text-primary-200 px-2 py-1 rounded-sm inline-flex items-center gap-1 select-none"
          :class="clickableClasses"
    >
        {{ name }}
        <XIcon v-if="icon === 'x'" class="size-4!"/>
        <PlusIcon v-if="icon === 'plus'" class="size-4!"/>
    </component>
</template>
<script setup lang="ts">
import XIcon from "@/components/icons/XIcon.vue";
import PlusIcon from "@/components/icons/PlusIcon.vue";
import {computed} from "vue";

const props = defineProps<{
    name: string,
    icon?: 'x' | 'plus',
    clickable?: boolean,
    href?: string
}>()

const clickableClasses = computed(() => {
    return !props.clickable ? '' : 'cursor-pointer hover:bg-primary-500/30 hover:text-primary-100'
})
</script>
