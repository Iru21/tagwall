import {defineStore, storeToRefs} from "pinia";
import {computed, ref} from "vue";
import {usePage} from "@inertiajs/vue3";
import axios from "axios";

export enum NSFWDisplay {
    HIDE = 0,
    BLUR = 1,
    ALWAYS = 2
}

export interface SettingsState {
    home_timeline: boolean,
    grid_view: boolean,
    nsfw_display: NSFWDisplay
}

const DEFAULT_SETTINGS: SettingsState = {
    home_timeline: true,
    grid_view: false,
    nsfw_display: NSFWDisplay.BLUR
}

const LOCAL_STORAGE_KEY = 'tagwall:settings'

export const useSettingsStore = defineStore('settings', () => {
    function validate(object: any): SettingsState {
        const validated: any = {}
        for (const key in DEFAULT_SETTINGS) {
            const defaultValue = DEFAULT_SETTINGS[key as keyof SettingsState]
            if (!(key in object) || typeof object[key] !== typeof defaultValue) {
                validated[key] = defaultValue
            } else {
                validated[key] = object[key]
            }
        }
        return validated as SettingsState
    }

    function getSettings(): SettingsState {
        const item = localStorage.getItem(LOCAL_STORAGE_KEY);
        if(!item) return DEFAULT_SETTINGS
        return validate(JSON.parse(item))
    }

    const settings_ref = ref<SettingsState>(getSettings())
    const settings = computed(() => settings_ref.value)

    function setSettings(newSettings: SettingsState) {
        settings_ref.value = newSettings
        localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify(settings_ref.value))
    }

    const user = usePage().props.auth.user
    const authed = user !== null
    if(authed) {
        axios.get(route('settings.index')).then(saved => {
            const validated = validate(saved.data)
            localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify(validated))
            setSettings(validated)
        })
    }

    return {
        setSettings,
        settings_ref,
        settings
    }
});

export function getSettings() {
    return storeToRefs(useSettingsStore()).settings
}
