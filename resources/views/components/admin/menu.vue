<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';
import { ref, h, Component } from 'vue';

import {
    NMenu,
    NLayout,
    NLayoutSider,
} from 'naive-ui';

import { NIcon } from 'naive-ui'
import type { MenuOption } from 'naive-ui'
import {
    DashboardFilled,
} from '@vicons/material'
import { Person } from '@vicons/ionicons5';
import { PersonCall20Filled, Box20Filled } from '@vicons/fluent';

function renderIcon(icon: Component) {
    return () => h(NIcon, null, { default: () => h(icon) })
}

function renderLink(url: string, content: string) {
    return () => h(Link, { href: url }, () => content)
}

const menuOptions: MenuOption[] = [
    {
        label: renderLink('/admin', 'Dashboard'),
        key: 'dashboard',
        icon: renderIcon(DashboardFilled)
    },
    {
        label: renderLink('/admin/users', 'Data Pengguna'),
        key: 'user-data',
        icon: renderIcon(Person),
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
]

defineProps<{ active: string }>();

const collapsed = ref(false);
</script>
<template>
    <n-layout has-sider>
        <n-layout-sider collapse-mode="width" :collapsed-width="64" :width="240" :collapsed="collapsed" show-trigger
            @collapse="collapsed = true" @expand="collapsed = false">
            <n-menu v-model:value="active" :options="menuOptions" :collapsed-width="64" :collapsed="collapsed" />
        </n-layout-sider>
        <slot />
    </n-layout>
</template>
