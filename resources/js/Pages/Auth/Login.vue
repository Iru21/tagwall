<template>
    <Head>
        <title>Login</title>
    </Head>
    <MainLayout>
        <Card>
            <h2>Login</h2>
            <Form #default="{ errors, processing }"
                :action="route('login')" method="post">
                <label for="username">
                    Username
                    <input id="username" name="username" type="text" placeholder="..."/>
                </label>
                <span v-if="errors.username" class="text-error">{{ errors.username }}</span>
                <label for="password">
                    Password
                    <input id="password" name="password" type="password" placeholder="..."/>
                </label>
                <BaseButton :loading="processing" type="submit">Login</BaseButton>
            </Form>
        </Card>
    </MainLayout>
</template>
<script setup lang="ts">
import Card from "@/components/Card.vue";
import {Form, Head} from "@inertiajs/vue3";
import BaseButton from "@/components/base/BaseButton.vue";
import MainLayout from "@/components/layouts/MainLayout.vue";
</script>
