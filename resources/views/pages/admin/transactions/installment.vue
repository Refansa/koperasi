<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import { h } from 'vue';
import { InstallmentProperties } from '@/scripts/composables/model';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import { NH1, NSpace, NDataTable, DataTableColumns, NButton } from 'naive-ui';
import route from 'ziggy-js';

defineProps<{ installments: InstallmentProperties[] }>();

const active = 'installment-data';

const createColumns = (): DataTableColumns<InstallmentProperties> => {
    return [
        {
            title: 'No Transaksi',
            key: 'id',
            sorter: 'default',
            render(u) {
                return `A-${u.id}`;
            },
        },
        {
            title: 'No Pinjam',
            key: 'loan.id',
            sorter: (a, b) => (a.loan?.id ?? 0) - (b.loan?.id ?? 0),
            render(u) {
                return `P-${u.loan?.id}`;
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
            title: 'Angsuran',
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
            title: 'Angsuran Ke',
            key: 'installment_of',
            sorter: (a, b) => a.installment_of - b.installment_of,
        },
        {
            title: 'Sisa Tenor',
            key: 'installment_left',
            sorter: (a, b) => a.installment_left - b.installment_left,
        },
        {
            title: 'Keterangan',
            key: 'note',
            sorter: 'default',
        },
        {
            title: 'Aksi',
            key: 'actions',
            align: 'center',
            width: 100,
            render(u) {
                return h(
                    Link,
                    {
                        href: route('admin.installment.receipt', u.id),
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
        <title>Admin | Data Transaksi Angsuran</title>
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
                <n-h1 align="center">Data Transaksi Angsuran</n-h1>
                <n-data-table
                    :bordered="false"
                    :single-line="false"
                    :columns="columns"
                    :data="installments"
                    :scroll-x="1600"
                    :pagination="{ pageSize: 10 }" />
            </n-space>
        </template>
    </admin-layout>
</template>
