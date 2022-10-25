<script setup lang="ts">
import Navbar from '@/views/components/navbar.vue';

import {
    NLayout,
    NLayoutHeader
} from 'naive-ui';

</script>
<template layout="default">
    <n-layout>
        <n-layout-header bordered>
            <navbar active="home" />
        </n-layout-header>
    </n-layout>
</template>
