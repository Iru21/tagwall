<template>
    <fieldset :class="[settings.styles]">
        <legend>
            <span class="mx-2">
                <component :is="settings.icon" class="mr-2"/>
                {{ settings.title }}
            </span>
        </legend>
        <slot />
    </fieldset>
</template>
<script setup lang="ts">
import InfoIcon from "@/components/icons/InfoIcon.vue";
import {computed} from "vue";
import CheckIcon from "@/components/icons/CheckIcon.vue";

const kinds = {
    'note': {
        title: 'Note',
        icon: InfoIcon,
        styles: 'border-blue-300 bg-blue-950/50 text-blue-100'
    },
    'success': {
        title: 'Success',
        icon: CheckIcon,
        styles: 'border-green-300 bg-green-950/50 text-green-100'
    }
}

const props = defineProps<{
    kind: keyof typeof kinds
}>()

const settings = computed(() => kinds[props.kind])
</script>
