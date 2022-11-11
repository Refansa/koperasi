<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import { h } from 'vue';
import { DivisionProperties } from '@/scripts/composables/model';
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

defineProps<{ divisions: DivisionProperties[] }>();

const active = 'division-data';

const createColumns = (): DataTableColumns<DivisionProperties> => {
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
            title: 'ID',
            key: 'id',
            sorter: 'default',
        },
        {
            title: 'Bagian',
            key: 'position',
            sorter: 'default',
        },
        {
            title: 'Aksi',
            key: 'actions',
            align: 'center',
            width: 200,
            render(u) {
                return h(AdminDataAction, {
                    editHref: `/admin/divisions/${u.id}/edit`,
                    deleteHref: `/admin/divisions/${u.id}`,
                });
            },
        },
    ];
};

const columns = createColumns();
</script>
<template layout="default">
    <Head>
        <title>Admin | Data Bagian</title>
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
                <n-h1 align="center">Data Bagian</n-h1>
                <Link href="/admin/divisions/create">
                    <n-button type="primary">Bagian Baru</n-button>
                </Link>
                <n-data-table
                    :bordered="false"
                    :single-line="false"
                    :columns="columns"
                    :data="divisions"
                    :scroll-x="800"
                    :pagination="{ pageSize: 10 }" />
            </n-space>
        </template>
    </admin-layout>
</template>
