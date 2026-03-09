<template>
    <Head :title="'Error ' + status" />
    <MainLayout>
        <BigLogo />
        <Card class="flex flex-col gap-4">
            <Alert :title="'Error ' + status" kind="error">
                {{ message }}
            </Alert>
            <Button class="w-fit ml-auto" as="a" :href="route('home')">Go back home</Button>
        </Card>
    </MainLayout>
</template>
<script setup lang="ts">
import MainLayout from "@/layouts/MainLayout.vue";
import {Head} from "@inertiajs/vue3";
import BigLogo from "@/components/BigLogo.vue";
import Alert from "@/components/Alert.vue";
import Card from "@/components/Card.vue";
import {ref} from "vue";
import Button from "@/components/input/Button.vue";

const props = defineProps<{
    status: number
}>()

const message = ref("")

switch(props.status) {
    case 403:
        message.value = "You are not authorized to perform this action."
        break
    case 404:
        message.value = "The page you are looking for does not exist."
        break
    case 500:
        message.value = "An error occurred while processing your request."
        break
    case 503:
        message.value = "The server is currently unavailable."
        break
}
</script>
