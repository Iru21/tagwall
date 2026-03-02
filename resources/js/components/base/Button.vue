<template>
    <component :is="as" :disabled="loading || disabled"
               class="inline-flex items-center gap-2 rounded-xs cursor-pointer disabled:cursor-not-allowed"
               :class="[kindClasses, sizeClasses]">
        <slot name="icon"/>
        <span><slot/></span>
        <LoadingIcon :class="size == 'md' ? '' : 'size-4!'" class="ml-auto" v-if="loading"/>
    </component>
</template>
<script setup lang="ts">
import {computed} from "vue";
import LoadingIcon from "@/components/icons/LoadingIcon.vue";

const props = withDefaults(defineProps<{
    as?: 'button' | 'a'
    kind?: 'primary' | 'secondary' | 'primary-dark' | 'danger-dark',
    loading?: boolean,
    disabled?: boolean,
    size?: 'sm' | 'md'
}>(), {
    as: 'button',
    kind: 'primary',
    loading: false,
    disabled: false,
    size: 'md'
})

const kindClasses = computed(() => {
    switch (props.kind) {
        case 'primary':
            return 'bg-primary-400 text-text hover:bg-primary-500 disabled:bg-muted-400 disabled:text-muted-600'
        case 'secondary':
            return 'bg-secondary-400 text-text hover:bg-secondary-500 disabled:bg-muted-400 disabled:text-muted-600'
        case 'primary-dark':
            return 'bg-primary-800 border border-primary-400 text-text hover:bg-primary-700 disabled:bg-muted-400 disabled:text-muted-600'
        case 'danger-dark':
            return 'bg-rose-900 border border-rose-400 text-text hover:bg-rose-800 disabled:bg-muted-400 disabled:text-muted-600'
    }
})

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'sm':
            return 'px-2 py-1 text-sm'
        case 'md':
            return 'px-4 py-2 text-base'
    }
})
</script>
