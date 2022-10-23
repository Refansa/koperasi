<script setup lang="ts">
// This is a persistent layout
// Include me with <template layout="default" />
import { NConfigProvider, NGlobalStyle, darkTheme } from 'naive-ui';
</script>

<template>
    <n-config-provider :theme="darkTheme">
        <n-global-style />
        <slot />
    </n-config-provider>
</template>
