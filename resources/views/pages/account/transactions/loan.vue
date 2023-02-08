<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import { h } from 'vue';
import { LoanProperties } from '@/scripts/composables/model';
import UserMenu from '@/views/components/user/user-menu.vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import UserLayout from '@/views/layouts/user-layout.vue';
import {
    NH1,
    NSpace,
    NDataTable,
    DataTableColumns,
    NButton,
    NTag,
} from 'naive-ui';
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
            title: 'Jumlah Total',
            key: 'loan.total',
            sorter: (a, b) => {
                const total = (v: LoanProperties) => {
                    return (
                        (v.transaction?.amount ?? 0) +
                        ((v.transaction?.amount ?? 0) *
                            (v.interest * v.loan_period)) /
                            100
                    );
                };
                return total(a) - total(b);
            },
            render: (u) => {
                const total = (v: LoanProperties) => {
                    return (
                        (v.transaction?.amount ?? 0) +
                        ((v.transaction?.amount ?? 0) *
                            (v.interest * v.loan_period)) /
                            100
                    );
                };

                return `Rp. ${total(u).toLocaleString('id-ID')}`;
            },
        },
        {
            title: 'Angsuran Per Bulan',
            key: 'loan.installment',
            sorter: (a, b) => {
                const installment = (v: LoanProperties) => {
                    return (
                        ((v.transaction?.amount ?? 0) +
                            ((v.transaction?.amount ?? 0) *
                                (v.interest * v.loan_period)) /
                                100) /
                        v.loan_period
                    );
                };
                return installment(a) - installment(b);
            },
            render: (u) => {
                const installment = (v: LoanProperties) => {
                    return (
                        ((v.transaction?.amount ?? 0) +
                            ((v.transaction?.amount ?? 0) *
                                (v.interest * v.loan_period)) /
                                100) /
                        v.loan_period
                    );
                };

                return `Rp. ${installment(u).toLocaleString('id-ID')}`;
            },
        },
        {
            title: 'Angsuran Ke',
            key: 'installment_tracker.installment_of',
            sorter: (a, b) =>
                (a.installment_tracker?.installment_of ?? 0) -
                (b.installment_tracker?.installment_of ?? 0),
        },
        {
            title: 'Keterangan',
            key: 'note',
            sorter: 'default',
        },
        {
            title: 'Status Peminjaman',
            key: 'status',
            align: 'center',
            sorter: (a, b) => {
                const x = (a.status ?? '').toLowerCase();
                const y = (b.status ?? '').toLowerCase();
                if (x < y) return -1;
                if (x > y) return 1;
                return 0;
            },
            render: (u) => {
                return h(
                    NTag,
                    { type: u.status === 'PAID' ? 'success' : 'error' },
                    () => u.status
                );
            },
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
                        href: route('account.loan.receipt', u.id),
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
        <title>Data Transaksi Pinjam</title>
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
                <n-h1 align="center">Data Transaksi Pinjam</n-h1>
                <n-data-table
                    :bordered="false"
                    :single-line="false"
                    :columns="columns"
                    :data="loans"
                    :scroll-x="1600"
                    :pagination="{ pageSize: 10 }" />
            </n-space>
        </template>
    </user-layout>
</template>
