<template>
    <Head title="Users - Admin Panel"/>
    <AdminLayout>
        <Card class="flex flex-col gap-4 mb-15">
            <h2>Users</h2>
            <Alert v-if="error" kind="error">
                {{ error }}
            </Alert>
            <div class="flex gap-4">
                <Form ref="filterFormRef" :action="route('admin.users')" method="get" class="flex-row! w-full"
                      #default="{ processing }" :options="{ preserveState: true, preserveScroll: true }">
                    <label for="search" class="w-full">
                        Search
                        <input id="search" name="search" type="text" v-model="filters.search" placeholder="..."
                        />
                    </label>
                    <label for="sort">
                        Sort by
                        <select id="sort" name="sort" v-model="filters.sort">
                            <option value="id">ID</option>
                            <option value="username">Username</option>
                            <option value="created_at" selected>Registered</option>
                            <option value="activated_at">Activated</option>
                            <option value="is_admin">Admin</option>
                        </select>
                    </label>
                    <label for="order">
                        Order
                        <select id="order" name="order" v-model="filters.order">
                            <option value="asc">Ascending</option>
                            <option value="desc" selected>Descending</option>
                        </select>
                    </label>
                    <Button :loading="processing" kind="primary" class="h-fit self-end" type="submit">Filter</Button>
                </Form>
            </div>
            <InfiniteScroll data="users" items-element="#table-body" :buffer="200">
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
                    <tbody id="table-body">
                        <tr v-for="user in users.data" :key="user.id">
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
                                    <Button v-if="user.activated_at" @click="deactivate(user.id)" kind="danger-dark"
                                            size="sm">
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
            </InfiniteScroll>
        </Card>
    </AdminLayout>
</template>
<script setup lang="ts">
import AdminLayout from "@/layouts/AdminLayout.vue";
import {User} from "@/types/global";
import Card from "@/components/Card.vue";
import {Head, router, InfiniteScroll, Form} from "@inertiajs/vue3";
import Button from "@/components/base/Button.vue";
import {ref} from "vue";
import Alert from "@/components/Alert.vue";

const props = defineProps<{
    users: {
        data: User[],
    },
    filters: {
        search: string,
        sort: string,
        order: string
    }
}>()

const filters = ref(props.filters)

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
    router.delete(route('admin.users.destroy', id), {
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
