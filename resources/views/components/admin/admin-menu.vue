<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';
import { inject, h, Component, Ref } from 'vue';

import { NMenu } from 'naive-ui';

import { NIcon } from 'naive-ui';
import type { MenuOption } from 'naive-ui';
import { DashboardFilled } from '@vicons/material';
import { Person, IdCard } from '@vicons/ionicons5';
import { PersonCall20Filled, Box20Filled } from '@vicons/fluent';

function renderIcon(icon: Component) {
    return () => h(NIcon, null, { default: () => h(icon) });
}

function renderLink(url: string, content: string) {
    return () => h(Link, { href: url }, () => content);
}

const menuOptions: MenuOption[] = [
    {
        label: renderLink('/admin', 'Dashboard'),
        key: 'dashboard',
        icon: renderIcon(DashboardFilled),
    },
    {
        label: 'Pengguna',
        key: 'user',
        icon: renderIcon(Person),
        children: [
            {
                label: renderLink('/admin/users', 'Data Pengguna'),
                key: 'user-data',
                icon: renderIcon(Person),
            },
            {
                label: renderLink('/admin/divisions', 'Data Bagian'),
                key: 'division-data',
                icon: renderIcon(IdCard),
            },
        ],
    },
    {
        label: renderLink('/admin/suppliers', 'Data Supplier'),
        key: 'supplier-data',
        icon: renderIcon(PersonCall20Filled),
    },
    {
        label: renderLink('/admin/items', 'Data Barang'),
        key: 'item-data',
        icon: renderIcon(Box20Filled),
    },
];

defineProps<{ active: string }>();
const collapsed = inject('sidebarCollapsed') as Ref<boolean> | undefined;
</script>
<template>
    <n-menu
        v-model:value="active"
        :options="menuOptions"
        :collapsed-width="64"
        :collapsed="collapsed" />
</template>
