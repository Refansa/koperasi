<script setup lang="ts">
// This is a persistent layout
// Include me with <template layout="default" />
import { provide } from 'vue';
import { useTheme } from '@/scripts/composables/theme';
import Messenger from '@/views/components/messenger.vue';
import {
    NGlobalStyle,
    NConfigProvider,
    NMessageProvider,
    NDialogProvider,
} from 'naive-ui';

const theme = useTheme();
provide('theme', theme);
</script>
<template>
    <n-config-provider :theme="theme">
        <n-global-style />
        <n-dialog-provider>
            <n-message-provider>
                <messenger />
                <slot />
            </n-message-provider>
        </n-dialog-provider>
    </n-config-provider>
</template>
