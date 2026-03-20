<template>
    <div>
        <input ref="input" type="file" :name="name" class="hidden" multiple
               @change="setFiles([...($event as any).target.files])">
        <div class="input h-auto! p-0! flex flex-col">
            <Button kind="primary-dark" type="button" @click="input?.click()">
                Select files
                <span v-if="files.length" class="text-muted-400">({{ files.length }})</span>
            </Button>
            <div class="flex flex-wrap gap-2 p-2 text-muted-400" v-if="files.length">
                <Tag v-for="file in files" :key="file.file.name" :name="file.file.name" icon="pencil" clickable
                     @click="showAttachmentEditModal(file)">
                    <img :alt="file.file.name" v-if="file.file.type.startsWith('image/')" :src="createObjectURL(file.file)"
                         class="size-6 object-cover rounded-sm"/>
                </Tag>
            </div>
        </div>
        <AttachmentEditModal :attachment="currentlyEditedAttachment"
                             :show="shouldShowAttachmentEditModal"
                             @close="closeAttachmentEditModal"
                             @delete="removeFile"
                             @update="updateFile"
        />
    </div>
</template>
<script setup lang="ts">
import {ref, useTemplateRef} from "vue";
import Button from "@/components/input/Button.vue";
import Tag from "@/components/Tag.vue";
import AttachmentEditModal from "@/components/modals/AttachmentEditModal.vue";
import {AttachedFile} from "@/types/global";

defineProps<{
    modelValue: AttachedFile[] | null
    name: string
}>()

const emit = defineEmits<{
    (e: 'update:modelValue', value: AttachedFile[] | null): void,
}>()

const input = useTemplateRef('input')

const files = ref<AttachedFile[]>([])
const setFiles = (newFiles: File[]) => {
    files.value = newFiles.map(file => ({
        file,
        alt: file.name,
        is_nsfw: false,
    }))
    emit('update:modelValue', files.value)
}

const updateFile = (file: AttachedFile) => {
    files.value = files.value.map(f => f.file === file.file ? file : f)
    emit('update:modelValue', files.value)
    closeAttachmentEditModal()
}

const removeFile = (file: AttachedFile) => {
    files.value = files.value.filter(f => f !== file)
    emit('update:modelValue', files.value)
    closeAttachmentEditModal()
}


const currentlyEditedAttachment = ref<AttachedFile | null>(null)
const shouldShowAttachmentEditModal = ref(false)
const showAttachmentEditModal = (file: AttachedFile) => {
    currentlyEditedAttachment.value = file
    shouldShowAttachmentEditModal.value = true
}
const closeAttachmentEditModal = () => {
    shouldShowAttachmentEditModal.value = false
    currentlyEditedAttachment.value = null
}

const createObjectURL = URL.createObjectURL
</script>
