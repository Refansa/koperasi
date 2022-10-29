<script setup lang="ts">
import { inject } from 'vue';

import { setTheme } from '@/scripts/composables/theme';

import {
    Moon,
    Sunny,
} from '@vicons/ionicons5';

import {
    NIcon,
    NSwitch,
    NTooltip,
} from 'naive-ui';

const theme: any = inject('theme');

const toggleTheme = () => {
    setTheme(theme);
};

</script>
<template>
    <n-tooltip trigger="hover">
        <template #trigger>
            <n-switch size="large" :value="theme.name === 'dark'" @click="toggleTheme">
                <template #checked-icon>
                    <n-icon :component="Moon" />
                </template>
                <template #unchecked-icon>
                    <n-icon :component="Sunny" />
                </template>
            </n-switch>
        </template>
        Ganti Tema
    </n-tooltip>
</template>
