<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import { h } from 'vue';
import { UserProperties } from '@/scripts/composables/model';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import { NH1, NSpace, NButton, NDataTable, DataTableColumns } from 'naive-ui';
import route from 'ziggy-js';

defineProps<{ users: UserProperties[] }>();

const active = 'savings-data';

const createColumns = (): DataTableColumns<UserProperties> => {
    return [
        {
            title: '#',
            key: 'index',
            align: 'center',
            width: 80,
            render(_u, index: number) {
                return h('span', [index + 1]);
            },
        },
        {
            title: 'Nama',
            key: 'name',
            sorter: 'default',
        },
        {
            title: 'Email',
            key: 'email',
            sorter: 'default',
        },
        {
            title: 'Pinjaman',
            key: 'm_saving.loan_amount',
            sorter: (a, b) => {
                return (
                    (a.m_saving?.loan_amount ?? 0) -
                    (b.m_saving?.loan_amount ?? 0)
                );
            },
            render(u) {
                return `Rp. ${(u.m_saving?.loan_amount ?? 0).toLocaleString(
                    'id-ID'
                )}`;
            },
        },
        {
            title: 'Tabungan Pokok',
            key: 'm_saving.basic_amount',
            sorter: (a, b) => {
                return (
                    (a.m_saving?.basic_amount ?? 0) -
                    (b.m_saving?.basic_amount ?? 0)
                );
            },
            render(u) {
                return `Rp. ${(u.m_saving?.basic_amount ?? 0).toLocaleString(
                    'id-ID'
                )}`;
            },
        },
        {
            title: 'Tabungan Wajib',
            key: 'm_saving.mandatory_amount',
            sorter: (a, b) => {
                return (
                    (a.m_saving?.mandatory_amount ?? 0) -
                    (b.m_saving?.mandatory_amount ?? 0)
                );
            },
            render(u) {
                return `Rp. ${(
                    u.m_saving?.mandatory_amount ?? 0
                ).toLocaleString('id-ID')}`;
            },
        },
        {
            title: 'Tabungan Sukarela',
            key: 'm_saving.voluntary_amount',
            sorter: (a, b) => {
                return (
                    (a.m_saving?.voluntary_amount ?? 0) -
                    (b.m_saving?.voluntary_amount ?? 0)
                );
            },
            render(u) {
                return `Rp. ${(
                    u.m_saving?.voluntary_amount ?? 0
                ).toLocaleString('id-ID')}`;
            },
        },
        {
            title: 'Total Tabungan',
            key: 'm_saving.total_amount',
            sorter: (a, b) => {
                return (
                    (a.m_saving?.basic_amount ?? 0) +
                    (a.m_saving?.mandatory_amount ?? 0) +
                    (a.m_saving?.voluntary_amount ?? 0) -
                    ((b.m_saving?.basic_amount ?? 0) +
                        (b.m_saving?.mandatory_amount ?? 0) +
                        (b.m_saving?.voluntary_amount ?? 0))
                );
            },
            render(u) {
                return `Rp. ${(
                    (u.m_saving?.basic_amount ?? 0) +
                    (u.m_saving?.mandatory_amount ?? 0) +
                    (u.m_saving?.voluntary_amount ?? 0)
                ).toLocaleString('id-ID')}`;
            },
        },
    ];
};

const columns = createColumns();
</script>
<template layout="default">
    <Head>
        <title>Admin | Data Tabungan</title>
    </Head>
    <admin-layout>
        <template #header>
            <navbar type="admin" />
        </template>
        <template #sidebar>
            <admin-menu :active="active"> </admin-menu>
        </template>
        <template #default>
            <n-space vertical>
                <n-h1 align="center">Data Tabungan</n-h1>
                <Link :href="route('admin.users.index')">
                    <n-button type="primary">Data Anggota</n-button>
                </Link>
                <n-data-table
                    :bordered="false"
                    :single-line="false"
                    :columns="columns"
                    :data="users"
                    :scroll-x="2000"
                    :pagination="{ pageSize: 10 }" />
            </n-space>
        </template>
    </admin-layout>
</template>
