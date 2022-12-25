<script setup lang="ts">
import { h } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import { CooperativeProperties, TransactionProperties } from '@/scripts/composables/model';
import {
    NSpace,
    NCard,
    NDataTable,
    DataTableColumns,
    NTag,
} from 'naive-ui';

defineProps<{
    today_transaction: TransactionProperties[],
    cooperative: CooperativeProperties;
}>();

const active = 'dashboard';

const createColumns = (): DataTableColumns<TransactionProperties> => {
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
            title: 'User ID',
            key: 'user.id',
            sorter: 'default',
        },
        {
            title: 'Nama',
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
            title: 'Jumlah Transaksi',
            key: 'amount',
            sorter: (a, b) => {
                return (
                    (a.amount ?? 0) - (b.amount ?? 0)
                );
            },
            render: (u) => {
                return `Rp. ${u.amount?.toLocaleString('id-ID')}`
            }
        },
        {
            title: 'Jenis Transaksi',
            key: 'transaction.type',
            align: 'center',
            render: (u) => {
                if (u.deposit) {
                    return h(NTag, { bordered: false }, ['Simpan']);
                }
                else if (u.withdraw) {
                    return h(NTag, { bordered: false }, ['Tarik']);
                }
                else if (u.loan) {
                    return h(NTag, { bordered: false }, ['Pinjam']);
                }
                else if (u.installment) {
                    return h(NTag, { bordered: false }, ['Angsuran']);
                }
            }
        }
    ];
};

const columns = createColumns();
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
                <n-card bordered title="Aktivitas Transaksi Hari Ini">
                    <n-data-table :columns="columns" :data="today_transaction" />
                </n-card>
            </n-space>
        </template>
    </admin-layout>
</template>
