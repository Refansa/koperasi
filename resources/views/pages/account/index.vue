<script setup lang="ts">
import { Head } from '@inertiajs/inertia-vue3';
import Navbar from '@/views/components/navbar/navbar.vue';
import UserLayout from '@/views/layouts/user-layout.vue';
import UserMenu from '@/views/components/user/user-menu.vue';

const active = 'dashboard';
</script>
<template layout="default">
    <Head>
        <title>Dashboard</title>
    </Head>
    <user-layout>
        <template #header>
            <navbar />
        </template>
        <template #sidebar>
            <user-menu :active="active"></user-menu>
        </template>
        <template #default> Hello World! </template>
    </user-layout>
</template>
