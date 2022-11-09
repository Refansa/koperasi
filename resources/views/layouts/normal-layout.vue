<script setup lang="ts">
import { NLayout, NLayoutHeader, NLayoutContent } from 'naive-ui';
</script>
<template>
    <n-layout>
        <n-layout-header
            bordered
            style="height: 64px">
            <slot name="header" />
        </n-layout-header>
        <n-layout-content content-style="padding: 2rem;">
            <slot />
        </n-layout-content>
    </n-layout>
</template>
