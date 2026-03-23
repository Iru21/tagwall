<template>
    <Head title="Settings"/>
    <AppLayout>
        <form @submit.prevent="submit">
            <Card class="flex flex-col gap-4">
                <h1>Settings</h1>
                <h5>Display</h5>
                <div class="fieldset">
                    <label class="w-60!" for="home_timeline">
                        Enable home timeline
                    </label>
                    <input id="home_timeline" name="home_timeline" type="checkbox" v-model="form.home_timeline"/>
                </div>
                <div class="fieldset">
                    <label class="w-60!" for="grid_view">
                        Display post images in a grid
                    </label>
                    <input id="grid_view" name="grid_view" type="checkbox" v-model="form.grid_view"/>
                </div>
                <div class="fieldset">
                    <label class="w-60!" for="nsfw_display">
                        Show NSFW
                    </label>
                    <select id="nsfw_display" name="nsfw_display" v-model="form.nsfw_display">
                        <option :value="NSFWDisplay.HIDE">Hide</option>
                        <option :value="NSFWDisplay.BLUR">Blur</option>
                        <option :value="NSFWDisplay.ALWAYS">Always show</option>
                    </select>
                </div>
                <Button :loading="form.processing" class="w-fit" type="submit" kind="primary">
                    Save
                </Button>
                <Alert kind="success" v-if="success">{{ success }}</Alert>
            </Card>
        </form>
    </AppLayout>
</template>
<script setup lang="ts">

import {Head, useForm, usePage} from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import Card from "@/components/Card.vue";
import {NSFWDisplay, SettingsState, useSettingsStore} from "@/stores/settings";
import Button from "@/components/input/Button.vue";
import {ref} from "vue";
import Alert from "@/components/Alert.vue";

const settingsStore = useSettingsStore();
const form = useForm<SettingsState>(settingsStore.settings)

const success = ref<string | null>(null)

const submit = () => {
    const save = () => {
        settingsStore.setSettings(form.data())
        success.value = 'Settings saved'
        setTimeout(() => {
            success.value = null
        }, 3000)
    }

    const user = usePage().props.auth.user
    const authed = user !== null
    if(authed) {
        form.put(route('settings.update'), {
            preserveScroll: true,
            onSuccess: save,
        })
    } else {
        save()
    }
}
</script>

