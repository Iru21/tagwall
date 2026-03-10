<template>
    <div>
        <input :required="required" ref="input" type="file" :name="name" class="hidden" multiple
               @change="setFiles([...($event as any).target.files])">
        <div class="input h-auto! p-0! flex flex-col">
            <Button kind="primary-dark" type="button" @click="input?.click()">
                Select files
                <span v-if="files.length" class="text-muted-400">({{ files.length }})</span>
            </Button>
            <div class="flex flex-wrap gap-2 p-2 text-muted-400" v-if="files.length">
                <Tag v-for="file in files" :key="file.name" :name="file.name" icon="x" clickable @click="removeFile(file)">
                    <img :alt="file.name" v-if="file.type.startsWith('image/')" :src="createObjectURL(file)"
                         class="size-6 object-cover rounded-sm"/>
                </Tag>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import {ref, useTemplateRef} from "vue";
import Button from "@/components/input/Button.vue";
import Tag from "@/components/Tag.vue";

defineProps<{
    modelValue: File[] | null
    name: string
    required?: boolean
}>()

const emit = defineEmits<{
    (e: 'update:modelValue', value: File[] | null): void
}>()

const input = useTemplateRef('input')

const files = ref<File[]>([])
const setFiles = (newFiles: File[]) => {
    files.value = newFiles
    emit('update:modelValue', newFiles)
}

const removeFile = (file: File) => {
    setFiles(files.value.filter(f => f !== file))
}

const createObjectURL = URL.createObjectURL
</script>
