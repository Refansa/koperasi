<script setup lang="ts">
import { h } from 'vue';

import AvatarMenu from '@/views/components/navbar/avatar-menu.vue';

import {
    NButton,
    NAvatar,
    NDropdown,
} from 'naive-ui';

const options = [
    {
        type: 'render',
        key: 'avatar-menu',
        render: () => h(AvatarMenu),
    },
];

</script>
<template>
    <n-dropdown style="background: transparent;" size="huge" trigger="click" :options="options">
        <n-button size="large" secondary circle>
            <n-avatar round src="/images/avatar-test.gif" />
        </n-button>
    </n-dropdown>
</template>
