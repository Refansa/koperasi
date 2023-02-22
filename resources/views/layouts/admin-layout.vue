<script setup lang="ts">
import { ref, provide, Ref, inject } from 'vue';
import {
    NLayout,
    NLayoutSider,
    NLayoutHeader,
    NLayoutContent,
    GlobalTheme,
} from 'naive-ui';

const theme: Ref<GlobalTheme> | undefined = inject('theme');

const sidebarCollapsed = ref(
    localStorage.getItem('admin-sidebar-collapse') === 'true' ? true : false
);
provide('sidebarCollapsed', sidebarCollapsed);

const setCollapse = () => {
    if (sidebarCollapsed.value) {
        sidebarCollapsed.value = false;
        localStorage.setItem('admin-sidebar-collapse', 'false');
    } else {
        sidebarCollapsed.value = true;
        localStorage.setItem('admin-sidebar-collapse', 'true');
    }
};
</script>
<template>
    <n-layout position="absolute">
        <n-layout-header
            bordered
            style="height: 64px">
            <slot name="header" />
        </n-layout-header>
        <n-layout
            has-sider
            position="absolute"
            style="top: 64px">
            <n-layout-sider
                bordered
                collapse-mode="width"
                :collapsed-width="64"
                :width="240"
                :collapsed="sidebarCollapsed"
                show-trigger
                @collapse="setCollapse"
                @expand="setCollapse">
                <slot name="sidebar" />
            </n-layout-sider>
            <n-layout-content
                :content-style="`padding: 2rem; ${
                    theme?.name == 'light'
                        ? 'background-color: rgb(0, 125, 0, 0.1);'
                        : ''
                }`">
                <slot />
            </n-layout-content>
        </n-layout>
    </n-layout>
</template>
