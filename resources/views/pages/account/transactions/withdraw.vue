<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import { h } from 'vue';
import { WithdrawProperties } from '@/scripts/composables/model';
import UserMenu from '@/views/components/user/user-menu.vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import UserLayout from '@/views/layouts/user-layout.vue';
import { NH1, NSpace, NDataTable, DataTableColumns, NButton } from 'naive-ui';
import route from 'ziggy-js';
import dayjs from 'dayjs';

defineProps<{ withdraws: WithdrawProperties[] }>();

const active = 'withdraw-data';

const createColumns = (): DataTableColumns<WithdrawProperties> => {
    return [
        {
            title: 'No Transaksi',
            key: 'id',
            sorter: 'default',
            render(u) {
                return `T-${u.id}`;
            },
        },
        {
            title: 'Jenis Simpanan',
            key: 'type',
            sorter: 'default',
        },
        {
            title: 'Jumlah Tarik',
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
            title: 'Tanggal Transaksi',
            key: 'created_at',
            sorter: 'default',
            render(u) {
                return dayjs(u.created_at).format('DD MMM YYYY');
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
                        href: route('account.withdraw.receipt', u.id),
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
        <title>Data Transaksi Tarik</title>
    </Head>
    <user-layout>
        <template #header>
            <navbar />
        </template>
        <template #sidebar>
            <user-menu :active="active"> </user-menu>
        </template>
        <template #default>
            <n-space vertical>
                <n-h1 align="center">Data Transaksi Tarik</n-h1>
                <n-data-table
                    :bordered="false"
                    :single-line="false"
                    :columns="columns"
                    :data="withdraws"
                    :scroll-x="800"
                    :pagination="{ pageSize: 10 }" />
            </n-space>
        </template>
    </user-layout>
</template>
