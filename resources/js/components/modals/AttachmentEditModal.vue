<template>
    <Modal title="Edit Attachment" :show="show" @close="$emit('close')">
        <form v-if="attachment" @submit.prevent="$emit('update', attachment)">
            <img :src="URL.createObjectURL(attachment.file)" class="object-cover rounded-sm mb-4" alt="Attachment preview">
            <label for="alt">
                Alt text
                <input id="alt" v-model="attachment.alt" type="text" placeholder="..."/>
            </label>
            <label for="is_nsfw">
                Is NSFW
                <input id="is_nsfw" v-model="attachment.is_nsfw" type="checkbox"/>
            </label>
            <div class="flex justify-end gap-2">
                <Button kind="primary" type="submit">Save</Button>
                <Button kind="danger" type="button" @click="$emit('delete', attachment)">Delete</Button>
            </div>
        </form>
    </Modal>
</template>
<script setup lang="ts">
import Modal from "@/components/Modal.vue";
import {AttachedFile} from "@/types/global";
import Button from "@/components/input/Button.vue";

defineProps<{
    show: boolean,
    attachment: AttachedFile | null,
}>()

defineEmits<{
    (e: 'close'): void,
    (e: 'update', attachment: AttachedFile): void,
    (e: 'delete', attachment: AttachedFile): void,
}>()

let URL = window.URL
</script>
