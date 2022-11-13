<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import { NSpace, NAlert, NGrid, NGridItem, NCard, NButton } from 'naive-ui';
import route from 'ziggy-js';

defineProps<{ user: number; supplier: number; item: number }>();

const active = 'dashboard';
</script>
<template layout="default">
    <Head>
        <title>Admin | Dashboard</title>
    </Head>
    <admin-layout>
        <template #header>
            <navbar type="admin" />
        </template>
        <template #sidebar>
            <admin-menu :active="active" />
        </template>
        <template #default>
            <n-space vertical>
                <n-alert
                    type="success"
                    title="Dashboard Koperasi"
                    :show-icon="false">
                    Saatnya koperasi siswa anda dikelola dengan profesional
                    melalui dukungan software yang membuat pengelolaan koperasi
                    siswa menjadi lebih mudah, rapi dan cepat.
                </n-alert>
                <n-grid
                    class="mt-10"
                    :x-gap="40"
                    :y-gap="40"
                    cols="1 m:3"
                    responsive="screen">
                    <n-grid-item>
                        <n-card
                            class="shadow-md"
                            title="Data Pengguna">
                            {{ user }} Pengguna
                            <template #action>
                                <Link :href="route('admin.users.index')">
                                    <n-button
                                        type="info"
                                        block
                                        >Lihat</n-button
                                    >
                                </Link>
                            </template>
                        </n-card>
                    </n-grid-item>
                    <n-grid-item>
                        <n-card
                            class="shadow-md"
                            title="Data Supplier">
                            {{ supplier }} Supplier
                            <template #action>
                                <Link :href="route('admin.suppliers.index')">
                                    <n-button
                                        type="info"
                                        block
                                        >Lihat</n-button
                                    >
                                </Link>
                            </template>
                        </n-card>
                    </n-grid-item>
                    <n-grid-item>
                        <n-card
                            class="shadow-md"
                            title="Data Barang">
                            {{ item }} Barang
                            <template #action>
                                <Link :href="route('admin.items.index')">
                                    <n-button
                                        type="info"
                                        block
                                        >Lihat</n-button
                                    >
                                </Link>
                            </template>
                        </n-card>
                    </n-grid-item>
                </n-grid>
            </n-space>
        </template>
    </admin-layout>
</template>
