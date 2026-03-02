<template>
    <Head title="Login" />
    <MainLayout>
        <BigLogo />
        <Card>
            <h2>Login</h2>
            <Form #default="{ errors, processing }"
                :action="route('login')" method="post">
                <Alert kind="success" v-if="success">{{ success }}</Alert>
                <label for="username">
                    Username
                    <input id="username" name="username" type="text" placeholder="..."/>
                </label>
                <label for="password">
                    Password
                    <input id="password" name="password" type="password" placeholder="..."/>
                </label>
                <span v-if="errors.username" class="text-error">{{ errors.username }}</span>
                <Button :loading="processing" type="submit">
                    Login
                </Button>
                <Link :href="route('register')">Don't have an account?</Link>
            </Form>
        </Card>
    </MainLayout>
</template>
<script setup lang="ts">
import Card from "@/components/Card.vue";
import {Form, Head, Link, usePage} from "@inertiajs/vue3";
import Button from "@/components/base/Button.vue";
import MainLayout from "@/layouts/MainLayout.vue";
import Alert from "@/components/Alert.vue";
import BigLogo from "@/components/BigLogo.vue";

const success = usePage().flash.success
</script>
