<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import { h } from 'vue';
import { UserProperties } from '@/scripts/composables/model';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import AdminDataAction from '@/views/components/admin/admin-data-action.vue';
import {
    NTag,
    NH1,
    NSpace,
    NDataTable,
    NButton,
    DataTableColumns,
} from 'naive-ui';
import route from 'ziggy-js';

defineProps<{ user: UserProperties[] }>();

const active = 'user-data';

const createColumns = (): DataTableColumns<UserProperties> => {
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
            title: 'Bagian',
            key: 'division.position',
            sorter: (a, b) => {
                const x = (a.division?.position ?? '').toLowerCase();
                const y = (b.division?.position ?? '').toLowerCase();
                if (x < y) return -1;
                if (x > y) return 1;
                return 0;
            },
            render(u) {
                return h(NTag, { bordered: false, type: 'primary' }, [
                    u.division?.position,
                ]);
            },
        },
        {
            title: 'Email',
            key: 'email',
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
            title: 'Hak Akses',
            key: 'role',
            sorter: 'default',
            render(u) {
                if (u.role == 'admin') {
                    return h(NTag, { bordered: false, type: 'info' }, [
                        u.role,
                    ]);
                }
                return h(NTag, { bordered: false, type: 'primary' }, [u.role]);
            },
        },
        {
            title: 'Aksi',
            key: 'actions',
            align: 'center',
            render(u) {
                return h(AdminDataAction, {
                    editHref: route('admin.users.edit', u.id),
                    deleteHref: route('admin.users.destroy', u.id),
                });
            },
        },
    ];
};

const columns = createColumns();
</script>
<template layout="default">
    <Head>
        <title>Admin | Data Pengguna</title>
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
                <n-h1 align="center">Data Pengguna</n-h1>
                <Link :href="route('admin.users.create')">
                    <n-button type="primary">Pengguna Baru</n-button>
                </Link>
                <n-data-table
                    :bordered="false"
                    :single-line="false"
                    :columns="columns"
                    :data="user"
                    :scroll-x="1800"
                    :pagination="{ pageSize: 10 }" />
            </n-space>
        </template>
    </admin-layout>
</template>
