<script setup lang="ts">

import { Link } from '@inertiajs/inertia-vue3';

import { NCard, NAvatar, NSpace, NButton, NDivider, NMenu, NIcon } from 'naive-ui';
import type { MenuOption } from 'naive-ui';
import { LogIn, LogOut } from '@vicons/ionicons5';
import { h } from 'vue';

const options: MenuOption[] = [
    {
        label: () => h(Link, { href: '/signin' }, () => 'Sign In'),
        key: 'signin',
        icon: () => h(NIcon, null, () => h(LogIn)),
    },
    {
        label: () => h(Link, { as: 'button', href: '/signout', method: 'post' }, () => 'Sign Out'),
        key: 'signout',
        icon: () => h(NIcon, null, () => h(LogOut)),
    },
];

</script>
<template>
    <n-card>
        <n-space vertical align="center" justify="center">
            <n-avatar style="background: transparent; border: 1px solid var(--n-color)" bordered object-fit="scale-down"
                :size="64" round src="/favicon.ico">
            </n-avatar>
            <div class="flex flex-col items-center">
                <h3 class="font-bold text-xl">Muhammad Refansa Ali Muzky</h3>
                <h4 class="font-bold">m.refansa.am@gmail.com</h4>
            </div>
            <n-button size="large" ghost>Kelola akun Anda</n-button>
        </n-space>
        <n-divider />
        <n-menu :options="options" />
    </n-card>
</template>
