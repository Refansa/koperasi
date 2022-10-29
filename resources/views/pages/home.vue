<script setup lang="ts">
import { Head } from '@inertiajs/inertia-vue3';

import Navbar from '@/views/components/navbar/navbar.vue';
import Messenger from '@/views/components/messenger.vue';

import {
    NLayout,
    NLayoutHeader
} from 'naive-ui';

</script>
<template layout="default">
    <messenger />

    <Head>
        <title>Halaman Utama</title>
    </Head>
    <n-layout>
        <n-layout-header bordered>
            <navbar active="home" />
        </n-layout-header>
    </n-layout>
</template>
