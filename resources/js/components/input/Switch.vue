<template>
    <div class="flex bg-background border border-border rounded-sm overflow-hidden w-fit" :class="[alignClass]">
        <div v-for="option in options" :key="option.value" class="flex items-center gap-2">
            <input :id="option.value" type="checkbox" class="hidden peer" :value="option.value" v-model="selected">
            <label :for="option.value" class="flex items-center gap-2 cursor-pointer peer-checked:bg-secondary-600 px-2 py-1">
                <component v-if="option.icon" :is="option.icon"/>
                <template v-if="option.label">{{ option.label }}</template>
            </label>
        </div>
    </div>
</template>
<script setup lang="ts">
import {computed, ref, watch} from "vue";
import type {Component} from "vue";

const props = withDefaults(defineProps<{
    vertical?: boolean
    radio?: boolean
    modelValue?: string[],
    options: {
        label?: string,
        icon?: Component,
        value: string
    }[],
    undeselectable?: boolean
}>(), {
    vertical: false,
    radio: true,
    modelValue: () => [],
    options: () => [],
    undeselectable: false,
})

const emit = defineEmits<{
    (e: 'update:modelValue', value: string[]): void
}>()

const selected = ref<string[]>(props.modelValue)

watch(
    () => selected.value,
    (currentSelected: string[], oldSelected: string[]) => {
        if(props.undeselectable && currentSelected.length === 0) {
            selected.value = oldSelected
            return
        }
        if(props.radio && currentSelected.length > 1) {
            selected.value = [currentSelected[currentSelected.length - 1]]
        }
        emit('update:modelValue', selected.value)
    },
    {deep: true}
)

const alignClass = computed(() => {
    return props.vertical ? 'flex-col' : 'flex-row'
})
</script>
