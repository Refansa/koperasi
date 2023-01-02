<script setup lang="ts">
import { h } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import {
    CooperativeProperties,
    TransactionProperties,
} from '@/scripts/composables/model';
import {
    NSpace,
    NCard,
    NDataTable,
    DataTableColumns,
    NTag,
    NH1,
    NGrid,
    NGridItem,
    NAlert,
} from 'naive-ui';

defineProps<{
    users: number;
    today_transaction: TransactionProperties[];
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
            width: 120,
            align: 'center',
            sorter: (a, b) => {
                return (a.user?.id ?? 0) - (b.user?.id ?? 0);
            },
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
                return (a.amount ?? 0) - (b.amount ?? 0);
            },
            render: (u) => {
                return `Rp. ${u.amount?.toLocaleString('id-ID')}`;
            },
        },
        {
            title: 'Jenis Transaksi',
            key: 'transaction.type',
            align: 'center',
            render: (u) => {
                if (u.deposit) {
                    return h(NTag, { bordered: false, type: 'primary' }, [
                        'Simpan',
                    ]);
                } else if (u.withdraw) {
                    return h(NTag, { bordered: false, type: 'primary' }, [
                        'Tarik',
                    ]);
                } else if (u.loan) {
                    return h(NTag, { bordered: false, type: 'primary' }, [
                        'Pinjam',
                    ]);
                } else if (u.installment) {
                    return h(NTag, { bordered: false, type: 'primary' }, [
                        'Angsuran',
                    ]);
                }
            },
        },
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
            <n-h1>Dashboard</n-h1>
            <n-space vertical>
                <n-grid
                    x-gap="12"
                    y-gap="12"
                    :cols="4">
                    <n-grid-item>
                        <n-alert
                            type="error"
                            :show-icon="false">
                            <div class="flex flex-col gap-4">
                                <h4 class="text-xl">Total Tabungan (Kotor)</h4>
                                <h4 class="text-xl">
                                    Rp.
                                    {{
                                        cooperative.total_deposit_amount.toLocaleString(
                                            'id-ID'
                                        )
                                    }}
                                </h4>
                            </div>
                        </n-alert>
                    </n-grid-item>
                    <n-grid-item>
                        <n-alert
                            type="warning"
                            :show-icon="false">
                            <div class="flex flex-col gap-4">
                                <h4 class="text-xl">Total Dipinjam</h4>
                                <h4 class="text-xl">
                                    Rp.
                                    {{
                                        cooperative.total_loan_amount.toLocaleString(
                                            'id-ID'
                                        )
                                    }}
                                </h4>
                            </div>
                        </n-alert>
                    </n-grid-item>
                    <n-grid-item>
                        <n-alert
                            type="success"
                            :show-icon="false">
                            <div class="flex flex-col gap-4">
                                <h4 class="text-xl">Total Tabungan (Bersih)</h4>
                                <h4 class="text-xl">
                                    Rp.
                                    {{
                                        (
                                            cooperative.total_deposit_amount -
                                            cooperative.total_loan_amount
                                        ).toLocaleString('id-ID')
                                    }}
                                </h4>
                            </div>
                        </n-alert>
                    </n-grid-item>
                    <n-grid-item>
                        <n-alert
                            type="info"
                            :show-icon="false">
                            <div class="flex flex-col gap-4">
                                <h4 class="text-xl">Total Anggota</h4>
                                <h4 class="text-xl">{{ users }} Anggota</h4>
                            </div>
                        </n-alert>
                    </n-grid-item>
                </n-grid>
                <n-card
                    bordered
                    title="Aktivitas Transaksi Hari Ini">
                    <n-data-table
                        :bordered="false"
                        :single-line="false"
                        :columns="columns"
                        :pagination="{ pageSize: 10 }"
                        :data="today_transaction" />
                </n-card>
            </n-space>
        </template>
    </admin-layout>
</template>
