<script setup lang="ts">
import { Head } from '@inertiajs/inertia-vue3';
import Navbar from '@/views/components/navbar/navbar.vue';
import NormalLayout from '@/views/layouts/normal-layout.vue';
</script>
<template layout="default">
    <Head>
        <title>Halaman Utama</title>
    </Head>
    <normal-layout>
        <template #header>
            <navbar />
        </template>
    </normal-layout>
</template>
