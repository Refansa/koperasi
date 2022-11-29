<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import { h } from 'vue';
import { LoanProperties } from '@/scripts/composables/model';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import { NH1, NSpace, NDataTable, DataTableColumns, NButton } from 'naive-ui';
import route from 'ziggy-js';

defineProps<{ loans: LoanProperties[] }>();

const active = 'loan-data';

const createColumns = (): DataTableColumns<LoanProperties> => {
    return [
        {
            title: 'No Transaksi',
            key: 'id',
            sorter: 'default',
            render(u) {
                return `P-${u.id}`;
            },
        },
        {
            title: 'Tenor',
            key: 'loan_period',
            sorter: (a, b) => a.loan_period - b.loan_period,
            render: (u) => `${u.loan_period} Bulan`,
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
            title: 'Bunga',
            key: 'interest',
            sorter: (a, b) => a.interest - b.interest,
            render: (u) => {
                return `${u.interest}%`;
            },
        },
        {
            title: 'Jumlah Pinjaman',
            key: 'transaction.amount',
            sorter: (a, b) =>
                (a.transaction?.amount ?? 0) - (b.transaction?.amount ?? 0),
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
                        href: route('admin.loan.receipt', u.id),
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
        <title>Admin | Data Transaksi Pinjam</title>
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
                <n-h1 align="center">Data Transaksi Pinjam</n-h1>
                <n-data-table
                    :bordered="false"
                    :single-line="false"
                    :columns="columns"
                    :data="loans"
                    :scroll-x="800"
                    :pagination="{ pageSize: 10 }" />
            </n-space>
        </template>
    </admin-layout>
</template>
