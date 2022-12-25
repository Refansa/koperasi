<script setup lang="ts">
import { ref, provide } from 'vue';
import { NLayout, NLayoutSider, NLayoutHeader, NLayoutContent } from 'naive-ui';

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
                content-style="padding: 2rem;">
                <slot />
            </n-layout-content>
        </n-layout>
    </n-layout>
</template>
