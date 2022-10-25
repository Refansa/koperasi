<script setup lang="ts">
// This is a persistent layout
// Include me with <template layout="default" />
import { useTheme } from '@/scripts/composables/theme';
import { NConfigProvider, NGlobalStyle } from 'naive-ui';
import { provide } from 'vue';

const theme = useTheme();
provide('theme', theme);

</script>
<template>
    <n-config-provider :theme="theme">
        <n-global-style />
        <slot />
    </n-config-provider>
</template>
