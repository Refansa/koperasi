<script setup lang="ts">
import { Head } from '@inertiajs/inertia-vue3';

import AdminMenu from '@/views/components/admin/menu.vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import Messenger from '@/views/components/messenger.vue';

import {
    NCard,
    NIcon,
    NThing,
    NAvatar,
    NGrid,
    NGridItem,
    NAlert,
    NLayout,
    NSpace,
    NLayoutHeader,
    NLayoutContent,
} from 'naive-ui';

import {
    Person
} from '@vicons/ionicons5';

import { PersonCall20Filled, Box20Filled } from '@vicons/fluent';

defineProps<{ user: number, supplier: number, item: number }>();

const active = 'dashboard';

</script>
<template layout="default">
    <messenger />

    <Head>
        <title>Admin Dashboard</title>
    </Head>
    <n-layout>
        <n-layout-header bordered>
            <navbar type="admin" />
        </n-layout-header>
        <n-layout-content>
            <admin-menu :active="active">
                <div class="w-full">
                    <n-space vertical class="p-10">
                        <n-alert title="Apa itu Koperasi?" :show-icon="false" type="info">
                            <span>
                                Koperasi adalah sebuah
                                organisasi ekonomi yang
                                dimiliki
                                dan dioperasikan oleh orang-seorang demi
                                kepentingan bersama.
                            </span>
                        </n-alert>
                        <n-grid cols="3" y-gap="10" x-gap="10" responsive="screen">
                            <n-grid-item>
                                <n-card>
                                    <n-thing>
                                        <template #avatar>
                                            <n-avatar>
                                                <n-icon>
                                                    <person />
                                                </n-icon>
                                            </n-avatar>
                                        </template>
                                        <template #header>
                                            <span class="font-bold">Data Pengguna</span>
                                        </template>
                                        <template #description>
                                            {{ user }} Pengguna
                                        </template>
                                    </n-thing>
                                </n-card>
                            </n-grid-item>
                            <n-grid-item>
                                <n-card>
                                    <n-thing>
                                        <template #avatar>
                                            <n-avatar>
                                                <n-icon>
                                                    <person-call-20-filled />
                                                </n-icon>
                                            </n-avatar>
                                        </template>
                                        <template #header>
                                            <span class="font-bold">Data Supplier</span>
                                        </template>
                                        <template #description>
                                            {{ supplier }} Supplier
                                        </template>
                                    </n-thing>
                                </n-card>
                            </n-grid-item>
                            <n-grid-item>
                                <n-card>
                                    <n-thing>
                                        <template #avatar>
                                            <n-avatar>
                                                <n-icon>
                                                    <box-20-filled />
                                                </n-icon>
                                            </n-avatar>
                                        </template>
                                        <template #header>
                                            <span class="font-bold">Data Barang</span>
                                        </template>
                                        <template #description>
                                            {{ item }} Barang
                                        </template>
                                    </n-thing>
                                </n-card>
                            </n-grid-item>
                        </n-grid>
                    </n-space>
                </div>
            </admin-menu>
        </n-layout-content>
    </n-layout>
</template>
