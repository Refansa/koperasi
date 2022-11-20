<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import { h } from 'vue';
import { DepositProperties } from '@/scripts/composables/model';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import { NH1, NSpace, NDataTable, DataTableColumns, NButton } from 'naive-ui';
import route from 'ziggy-js';

defineProps<{ deposits: DepositProperties[] }>();

const active = 'deposit-data';

const createColumns = (): DataTableColumns<DepositProperties> => {
    return [
        {
            title: 'No Transaksi',
            key: 'id',
            sorter: 'default',
            render(u) {
                return `D-${u.id}`;
            },
        },
        {
            title: 'Nama Pengguna',
            key: 'user.name',
            sorter: (a, b) => {
                const x = (a.user?.name ?? '').toLowerCase();
                const y = (b.user?.name ?? '').toLowerCase();
                if (x < y) return -1;
                if (x > y) return 1;
                return 0;
            },
        },
        {
            title: 'Jumlah Simpan',
            key: 'transaction.amount',
            sorter: (a, b) => {
                return (
                    (a.transaction?.amount ?? 0) - (b.transaction?.amount ?? 0)
                );
            },
            render: (u) => {
                return `Rp. ${(u.transaction?.amount ?? 0).toLocaleString(
                    'id-ID'
                )}`;
            },
        },
        {
            title: 'Aksi',
            key: 'actions',
            align: 'center',
            width: 200,
            render(u) {
                return h(
                    Link,
                    {
                        href: route('admin.deposit.receipt', u.id),
                    },
                    () => h(NButton, { type: 'primary' }, 'Lihat')
                );
            },
        },
    ];
};

const columns = createColumns();
</script>
<template layout="default">
    <Head>
        <title>Admin | Data Transaksi Simpan</title>
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
                <n-h1 align="center">Data Transaksi Simpan</n-h1>
                <n-data-table
                    :bordered="false"
                    :single-line="false"
                    :columns="columns"
                    :data="deposits"
                    :scroll-x="800"
                    :pagination="{ pageSize: 10 }" />
            </n-space>
        </template>
    </admin-layout>
</template>
