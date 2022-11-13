<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import { h } from 'vue';
import { ItemProperties } from '@/scripts/composables/model';
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
    NTag,
} from 'naive-ui';
import route from 'ziggy-js';

defineProps<{ items: ItemProperties[] }>();

const active = 'item-data';

const createColumns = (): DataTableColumns<ItemProperties> => {
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
            title: 'Nama Barang',
            key: 'name',
            sorter: 'default',
        },
        {
            title: 'Nama Supplier',
            key: 'supplier.name',
            sorter: (a, b) => {
                const x = (a.supplier?.name ?? '').toLowerCase();
                const y = (b.supplier?.name ?? '').toLowerCase();
                if (x < y) return -1;
                if (x > y) return 1;
                return 0;
            },
            render(u) {
                if (u.supplier?.name) return u.supplier?.name;
                return h(NTag, { bordered: false, type: 'error' }, [
                    'Tidak Ada Supplier',
                ]);
            },
        },
        {
            title: 'Stok Barang',
            key: 'stock',
            sorter: 'default',
        },
        {
            title: 'Harga Barang',
            key: 'price',
            sorter: 'default',
        },
        {
            title: 'Kategori Barang',
            key: 'item_category.category',
            sorter: (a, b) => {
                const x = (a.item_category?.category ?? '').toLowerCase();
                const y = (b.item_category?.category ?? '').toLowerCase();
                if (x < y) return -1;
                if (x > y) return 1;
                return 0;
            },
            render(u) {
                if (u.item_category?.category) {
                    return h(NTag, { bordered: false, type: 'primary' }, [
                        u.item_category?.category,
                    ]);
                }
                return h(NTag, { bordered: false, type: 'error' }, [
                    'Tidak Berkategori',
                ]);
            },
        },
        {
            title: 'Aksi',
            key: 'actions',
            align: 'center',
            render(u) {
                return h(AdminDataAction, {
                    editHref: route('admin.items.edit', u.id),
                    deleteHref: route('admin.items.destroy', u.id),
                });
            },
        },
    ];
};

const columns = createColumns();
</script>
<template layout="default">
    <Head>
        <title>Admin | Data Barang</title>
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
                <n-h1 align="center">Data Barang</n-h1>
                <Link :href="route('admin.items.create')">
                    <n-button type="primary">Barang Baru</n-button>
                </Link>
                <n-data-table
                    :bordered="false"
                    :single-line="false"
                    :columns="columns"
                    :data="items"
                    :scroll-x="1200"
                    :pagination="{ pageSize: 10 }" />
            </n-space>
        </template>
    </admin-layout>
</template>
