<template>
    <component :is="as" :disabled="loading || disabled"
               class="inline-flex items-center gap-2 rounded-xs px-4 py-2 cursor-pointer disabled:cursor-not-allowed"
               :class="[kindClasses]">
        <slot name="icon"/>
        <span><slot/></span>
        <LoadingIcon class="ml-auto" v-if="loading"/>
    </component>
</template>
<script setup lang="ts">
import {computed} from "vue";
import LoadingIcon from "@/components/icons/LoadingIcon.vue";

const props = withDefaults(defineProps<{
    as?: 'button' | 'a'
    kind?: 'primary' | 'secondary',
    loading?: boolean,
    disabled?: boolean
}>(), {
    as: 'button',
    kind: 'primary',
    loading: false,
    disabled: false
})

const kindClasses = computed(() => {
    switch (props.kind) {
        case 'primary':
            return 'bg-primary-400 text-text hover:bg-primary-500 disabled:bg-muted-400 disabled:text-muted-600'
        case 'secondary':
            return 'bg-secondary-400 text-text hover:bg-secondary-500 disabled:bg-muted-400 disabled:text-muted-600'
    }
})
</script>
