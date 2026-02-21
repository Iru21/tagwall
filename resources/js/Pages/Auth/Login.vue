<template>
    <Head>
        <title>Login</title>
    </Head>
    <MainLayout>
        <h1 class="text-9xl! text-center tracking-[.3em] mb-10!">Tagwall</h1>
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
                <BaseButton :loading="processing" type="submit">Login</BaseButton>
                    <Link :href="route('register')">Don't have an account?</Link>
            </Form>
        </Card>
    </MainLayout>
</template>
<script setup lang="ts">
import Card from "@/components/Card.vue";
import {Form, Head, Link, usePage} from "@inertiajs/vue3";
import BaseButton from "@/components/base/BaseButton.vue";
import MainLayout from "@/components/layouts/MainLayout.vue";
import Alert from "@/components/Alert.vue";

const success = usePage().flash.success
</script>
