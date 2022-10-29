<script setup lang="ts">
import { Head } from '@inertiajs/inertia-vue3';

import { onMounted } from 'vue';

import { useAlert } from '@/scripts/composables/alert';

import Navbar from '@/views/components/navbar/navbar.vue';

import {
    NLayout,
    NLayoutHeader
} from 'naive-ui';

onMounted(() => {
    useAlert();
});

</script>
<template layout="default">

    <Head>
        <title>Halaman Utama</title>
    </Head>
    <n-layout>
        <n-layout-header bordered>
            <navbar active="home" />
        </n-layout-header>
    </n-layout>
</template>
