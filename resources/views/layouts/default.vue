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
    GlobalThemeOverrides,
    NThemeEditor,
} from 'naive-ui';

const theme = useTheme();
provide('theme', theme);

const lightThemeOverrides: GlobalThemeOverrides = {
    DataTable: {
        thColor: '#18a058',
        thColorHover: '#36ad6a',
        thIconColor: '#eee',
        thIconColorActive: '#fff',
        thTextColor: '#fff',
        tdColor: 'rgb(245, 245, 245)',
        tdColorHover: 'rgb(250, 250, 250)',
        borderColor: 'rgb(255, 255, 255)',
    },
    Alert: {
        colorSuccess: 'rgb(24, 160, 88, 1)',
        titleTextColorSuccess: '#fff',
        contentTextColorSuccess: '#fff',
        colorWarning: 'rgb(240, 160, 32, 1)',
        titleTextColorWarning: '#fff',
        contentTextColorWarning: '#fff',
        colorError: 'rgb(208, 48, 80, 1)',
        titleTextColorError: '#fff',
        contentTextColorError: '#fff',
        colorInfo: 'rgb(32, 128, 240, 1)',
        titleTextColorInfo: '#fff',
        contentTextColorInfo: '#fff',
    },
};

const darkThemeOverrides: GlobalThemeOverrides = {
    DataTable: {
        thColor: '#63e2b7',
        thColorHover: '#7fe7c4',
        thIconColor: '#111',
        thIconColorActive: '#000',
        thTextColor: '#000',
        tdColor: 'rgb(34, 34, 38)',
    },
};
</script>
<template>
    <n-config-provider
        :theme="theme"
        :theme-overrides="
            theme.name == 'light' ? lightThemeOverrides : darkThemeOverrides
        ">
        <n-global-style />
        <n-dialog-provider>
            <n-message-provider>
                <messenger />
                <n-theme-editor>
                    <slot />
                </n-theme-editor>
            </n-message-provider>
        </n-dialog-provider>
    </n-config-provider>
</template>
