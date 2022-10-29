<script setup lang="ts">
// This is a persistent layout
// Include me with <template layout="default" />
import { provide } from 'vue';

import { useTheme } from '@/scripts/composables/theme';


import {
    NGlobalStyle,
    NThemeEditor,
    NConfigProvider,
    NMessageProvider,
} from 'naive-ui';

const theme = useTheme();
provide('theme', theme);

</script>
<template>
    <n-config-provider :theme="theme">
        <n-theme-editor />
        <n-global-style />
        <n-message-provider>
            <slot />
        </n-message-provider>
    </n-config-provider>
</template>
