<script setup lang="ts">
import { h } from 'vue';

import { Person } from '@vicons/ionicons5';

import { NDropdown, NButton } from 'naive-ui';

import AvatarMenu from '@/views/components/avatar-menu.vue';

const options = [
    {
        type: 'render',
        key: 'avatar-menu',
        render: () => h(AvatarMenu),
    },
];
</script>
<template>
    <n-dropdown style="background: transparent;" size="huge" trigger="click" :options="options" placement="bottom-end">
        <n-button size="large" secondary circle>
            <template #icon>
                <person />
            </template>
        </n-button>
    </n-dropdown>
</template>
