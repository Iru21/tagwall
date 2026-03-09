<template>
    <Head title="Register" />
    <MainLayout>
        <BigLogo />
        <Card>
            <h2>Register</h2>
            <Form #default="{ errors, processing }"
                :action="route('register')" method="post">
                <label for="username">
                    Username
                    <input id="username" name="username" type="text" placeholder="..."/>
                </label>
                <span v-if="errors.username" class="text-error">{{ errors.username }}</span>
                <label for="password">
                    Password
                    <input id="password" name="password" type="password" placeholder="..."/>
                </label>
                <label for="password_confirmation">
                    Confirm Password
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="..."/>
                </label>
                <span v-if="errors.password" class="text-error">{{ errors.password }}</span>
                <Alert kind="note" v-if="accountsRequireApproval">
                    Accounts require approval by an administrator before they can be used.
                </Alert>
                <Button :loading="processing" type="submit">Register</Button>
                <Link :href="route('login')">Already have an account?</Link>
            </Form>
        </Card>
    </MainLayout>
</template>
<script setup lang="ts">
import Card from "@/components/Card.vue";
import {Form, Head, Link} from "@inertiajs/vue3";
import Button from "@/components/input/Button.vue";
import MainLayout from "@/layouts/MainLayout.vue";
import Alert from "@/components/Alert.vue";
import BigLogo from "@/components/BigLogo.vue";

defineProps<{
    accountsRequireApproval: boolean
}>()
</script>
