<template>
    <Teleport to="#app">
        <div class="fixed inset-0 z-50 bg-primary-950/50 grid place-items-center" v-if="show" @click="$emit('close')">
            <Card class="w-full max-w-lg flex flex-col gap-4" @click.stop>
                <div class="flex justify-between items-center">
                    <h2>{{ title }}</h2>
                    <Button size="md-square" kind="invisible" @click="$emit('close')">
                        <template #icon>
                            <XIcon/>
                        </template>
                    </Button>
                </div>
                <slot />
            </Card>
        </div>

    </Teleport>
</template>
<script setup lang="ts">
import Card from "@/components/Card.vue";
import {onMounted, onUnmounted} from "vue";
import Button from "@/components/input/Button.vue";
import XIcon from "@/components/icons/XIcon.vue";

defineProps<{
    show: boolean,
    title: string
}>()

const emit = defineEmits<{
    (e: 'close'): void,
}>()

const escapeListener = (e: KeyboardEvent) => {
    if(e.key === 'Escape') {
        emit('close')
    }
}

onMounted(() => {
    window.addEventListener('keydown', escapeListener)
})

onUnmounted(() => {
    window.removeEventListener('keydown', escapeListener)
})
</script>
