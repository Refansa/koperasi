<script setup lang="ts">
import { NLayout, NLayoutHeader, NLayoutContent } from 'naive-ui';
</script>
<template>
    <n-layout>
        <n-layout-header
            bordered
            class="z-10 fixed"
            style="height: 64px">
            <slot name="header" />
        </n-layout-header>
        <n-layout-content>
            <slot />
        </n-layout-content>
    </n-layout>
</template>
