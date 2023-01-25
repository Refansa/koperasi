<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';
import { inject, h, Component, Ref } from 'vue';

import { NMenu } from 'naive-ui';

import { NIcon } from 'naive-ui';
import type { MenuOption } from 'naive-ui';
import { DashboardFilled } from '@vicons/material';

import route from 'ziggy-js';

function renderIcon(icon: Component) {
    return () => h(NIcon, null, { default: () => h(icon) });
}

function renderLink(url: string, content: string) {
    return () => h(Link, { href: url }, () => content);
}

const menuOptions: MenuOption[] = [
    {
        label: renderLink(route('admin.home'), 'Dashboard'),
        key: 'dashboard',
        icon: renderIcon(DashboardFilled),
    },
];

const props = defineProps<{ active: string }>();

const collapsed = inject('sidebarCollapsed') as Ref<boolean> | undefined;
</script>
<template>
    <n-menu
        v-model:value="props.active"
        :options="menuOptions"
        :collapsed-width="64"
        :collapsed="collapsed" />
</template>
