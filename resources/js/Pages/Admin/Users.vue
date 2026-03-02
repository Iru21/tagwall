<template>
    <Head title="Users - Admin Panel"/>
    <AdminLayout>
        <Card class="flex flex-col gap-4">
            <h2>Users</h2>
            <Alert v-if="error" kind="error">
                {{ error }}
            </Alert>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Activated (?)</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users.data">
                    <td>{{ user.id }}</td>
                    <td>{{ user.username }}</td>
                    <td>
                        <template v-if="user.activated_at">
                            {{ new Date(user.activated_at).toLocaleString('uk') }}
                        </template>
                        <template v-else class="text-muted/10">
                            Not activated
                        </template>
                    </td>
                    <td>{{ new Date(user.created_at).toLocaleString('uk') }}</td>
                    <td>
                        <div class="flex items-center gap-4" v-if="!user.is_admin">
                            <Button v-if="user.activated_at" @click="deactivate(user.id)" kind="danger-dark" size="sm">
                                Deactivate
                            </Button>
                            <Button v-else @click="activate(user.id)" type="submit" kind="primary-dark" size="sm">
                                Activate
                            </Button>
                            <Button @click="deleteUser(user.id)" kind="danger-dark" size="sm">
                                Delete
                            </Button>
                        </div>
                        <div v-else class="text-muted-600 text-center">
                            Admin
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </Card>
    </AdminLayout>
</template>
<script setup lang="ts">
import AdminLayout from "@/layouts/AdminLayout.vue";
import {Paginated, User} from "@/types/global";
import Card from "@/components/Card.vue";
import {Head, router} from "@inertiajs/vue3";
import Button from "@/components/base/Button.vue";
import {ref} from "vue";
import Alert from "@/components/Alert.vue";

defineProps<{
    users: Paginated<User>,
    filters: {
        perPage: number,
        page: number,
        search: string,
        sort: string,
        order: string
    }
}>()

const error = ref<string | null>(null)

const activate = (id: number) => {
    router.post(route('admin.users.activate', id), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            error.value = null
        },
        onError: (errors) => {
            error.value = errors.error
        }
    })
}
const deactivate = (id: number) => {
    router.post(route('admin.users.deactivate', id), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            error.value = null
        },
        onError: (errors) => {
            error.value = errors.error
        }
    })
}
const deleteUser = (id: number) => {
    router.delete(route('admin.users.destroy', id),{
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            error.value = null
        },
        onError: (errors) => {
            error.value = errors.error
        }
    })
}
</script>
