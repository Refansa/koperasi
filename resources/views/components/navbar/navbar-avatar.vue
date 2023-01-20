<script setup lang="ts">
import { h } from 'vue';
import { useAuth } from '@/scripts/composables/auth';
import AvatarMenu from '@/views/components/navbar/navbar-avatar-menu.vue';
import { NButton, NAvatar, NDropdown } from 'naive-ui';

const auth = useAuth();

const options = [
    {
        type: 'render',
        key: 'avatar-menu',
        render: () => h(AvatarMenu),
    },
];
</script>
<template>
    <n-dropdown
        style="background: transparent"
        size="huge"
        trigger="click"
        :options="options">
        <n-button
            size="large"
            secondary
            circle>
            <n-avatar
                round
                :src="auth.user.picture ?? '/images/default-profile.jpg'" />
        </n-button>
    </n-dropdown>
</template>
