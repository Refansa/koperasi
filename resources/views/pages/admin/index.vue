<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import KoperasiLogo from '@/views/components/koperasi-logo.vue';
import { CooperativeProperties } from '@/scripts/composables/model';
import {
    NSpace,
    NAlert,
    NGrid,
    NGridItem,
    NCard,
    NButton,
    NH1,
    NH2,
    NElement,
} from 'naive-ui';
import route from 'ziggy-js';

defineProps<{
    user: number;
    supplier: number;
    item: number;
    cooperative: CooperativeProperties;
}>();

const active = 'dashboard';
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
                <n-card :bordered="false">
                    <div class="flex flex-col items-start gap-4">
                        <koperasi-logo />
                        <p>
                            Saatnya koperasi siswa anda dikelola dengan
                            profesional melalui dukungan software yang membuat
                            pengelolaan koperasi siswa menjadi lebih mudah, rapi
                            dan cepat.
                        </p>
                    </div>
                </n-card>
                <n-card :bordered="false">
                    <n-h1>Total Keuangan Koperasi</n-h1>
                    <n-grid
                        :x-gap="40"
                        :y-gap="40"
                        cols="1 m:3"
                        responsive="screen">
                        <n-grid-item>
                            <n-card
                                class="shadow-md"
                                title="Total Tabungan Koperasi (Kotor)">
                                <n-h2>
                                    Rp.
                                    {{
                                        cooperative.total_deposit_amount.toLocaleString(
                                            'id-ID'
                                        )
                                    }}
                                </n-h2>
                            </n-card>
                        </n-grid-item>
                        <n-grid-item>
                            <n-card
                                class="shadow-md"
                                title="Total Pinjaman Koperasi">
                                <n-h2>
                                    Rp.
                                    {{
                                        cooperative.total_loan_amount.toLocaleString(
                                            'id-ID'
                                        )
                                    }}
                                </n-h2>
                            </n-card>
                        </n-grid-item>
                        <n-grid-item>
                            <n-card
                                class="shadow-md"
                                title="Total Tabungan Koperasi (Bersih)">
                                <n-h2>
                                    Rp.
                                    {{
                                        (
                                            cooperative.total_deposit_amount -
                                            cooperative.total_loan_amount
                                        ).toLocaleString('id-ID')
                                    }}
                                </n-h2>
                            </n-card>
                        </n-grid-item>
                    </n-grid>
                </n-card>
                <div class="mt-10">
                    <n-h1>Data Koperasi</n-h1>
                    <n-grid
                        :x-gap="40"
                        :y-gap="40"
                        cols="1 m:3"
                        responsive="screen">
                        <n-grid-item>
                            <n-card
                                class="shadow-md"
                                title="Data Pengguna">
                                {{ user }} Pengguna
                                <template #action>
                                    <Link :href="route('admin.users.index')">
                                        <n-button
                                            type="info"
                                            block
                                            >Lihat</n-button
                                        >
                                    </Link>
                                </template>
                            </n-card>
                        </n-grid-item>
                        <n-grid-item>
                            <n-card
                                class="shadow-md"
                                title="Data Supplier">
                                {{ supplier }} Supplier
                                <template #action>
                                    <Link
                                        :href="route('admin.suppliers.index')">
                                        <n-button
                                            type="info"
                                            block
                                            >Lihat</n-button
                                        >
                                    </Link>
                                </template>
                            </n-card>
                        </n-grid-item>
                        <n-grid-item>
                            <n-card
                                class="shadow-md"
                                title="Data Barang">
                                {{ item }} Barang
                                <template #action>
                                    <Link :href="route('admin.items.index')">
                                        <n-button
                                            type="info"
                                            block
                                            >Lihat</n-button
                                        >
                                    </Link>
                                </template>
                            </n-card>
                        </n-grid-item>
                    </n-grid>
                </div>
            </n-space>
        </template>
    </admin-layout>
</template>
