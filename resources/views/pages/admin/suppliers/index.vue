<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import { h } from 'vue';
import { SupplierProperties } from '@/scripts/composables/model';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import AdminDataAction from '@/views/components/admin/admin-data-action.vue';
import {
    NH1,
    NSpace,
    NDataTable,
    NButton,
    DataTableColumns,
} from 'naive-ui';

defineProps<{ suppliers: SupplierProperties[] }>();

const active = 'supplier-data';

const createColumns = (): DataTableColumns<SupplierProperties> => {
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
            title: 'Alamat',
            key: 'address',
            sorter: 'default',
        },
        {
            title: 'Kontak',
            key: 'contact',
            sorter: 'default',
        },
        {
            title: 'Aksi',
            key: 'actions',
            align: 'center',
            render(u) {
                return h(AdminDataAction, {
                    editHref: `/admin/suppliers/${u.id}/edit`,
                    deleteHref: `/admin/suppliers/${u.id}`,
                });
            },
        },
    ];
};

const columns = createColumns();
</script>
<template layout="default">
    <Head>
        <title>Admin | Data Supplier</title>
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
                <n-h1 align="center">Data Supplier</n-h1>
                <Link href="/admin/suppliers/create">
                    <n-button type="primary">Supplier Baru</n-button>
                </Link>
                <n-data-table
                    :bordered="false"
                    :single-line="false"
                    :columns="columns"
                    :data="suppliers"
                    :scroll-x="1200"
                    :pagination="{ pageSize: 10 }" />
            </n-space>
        </template>
    </admin-layout>
</template>
