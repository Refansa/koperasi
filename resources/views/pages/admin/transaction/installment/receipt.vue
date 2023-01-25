<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import { InstallmentProperties } from '@/scripts/composables/model';
import { NCard, NSpace, NButton, NTable } from 'naive-ui';
import KoperasiLogo from '@/views/components/koperasi-logo.vue';
import dayjs from 'dayjs';
import route from 'ziggy-js';

const props = defineProps<{ installment: InstallmentProperties }>();

function printPDF() {
    window.open(route('admin.installment.print', props.installment.id));
}

const active = 'installment';
</script>
<template layout="default">
    <Head>
        <title>Admin | Kuitansi</title>
    </Head>
    <admin-layout>
        <template #header>
            <navbar type="admin" />
        </template>
        <template #sidebar>
            <admin-menu :active="active" />
        </template>
        <template #default>
            <n-card
                id="receipt"
                :segmented="{
                    content: true,
                }">
                <template #header>
                    <n-space justify="space-between">
                        <koperasi-logo />
                        <span class="text-sm font-black"
                            >Tanggal Transaksi:
                            {{
                                dayjs(installment.created_at).format(
                                    'YYYY-MM-DD HH:mm:ss'
                                )
                            }}</span
                        >
                    </n-space>
                </template>
                <template #default>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
                        <div>
                            <h3 class="underline">Koperasi:</h3>
                            <p class="font-black">Koperasi Jaya</p>
                            <p>Alamat: Jl. Menuju Kesuksesan</p>
                            <p>Phone: (+62) 81234567890</p>
                            <p>Email: admin@koperasi.com</p>
                        </div>
                        <div>
                            <h3 class="underline">To:</h3>
                            <p class="font-black">
                                {{ installment.user?.name }}
                            </p>
                            <p>Email: {{ installment.user?.email }}</p>
                            <p>Kontak: {{ installment.user?.contact }}</p>
                        </div>
                        <div>
                            <h3 class="font-black">
                                No Transaksi# A-{{ installment.id }}
                            </h3>
                            <p>
                                <span class="font-black">ID User:</span>
                                {{ installment.user?.id }}
                            </p>
                        </div>
                    </div>
                    <n-table
                        :bordered="false"
                        :single-line="false">
                        <thead>
                            <tr>
                                <th>No. Pinjam</th>
                                <th>ID User</th>
                                <th>Nama</th>
                                <th>Angsuran #</th>
                                <th>Sisa Tenor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>P-{{ installment.loan?.id }}</td>
                                <td>{{ installment.user?.id }}</td>
                                <td>{{ installment.user?.name }}</td>
                                <td>
                                    Rp.
                                    {{
                                        installment.transaction?.amount?.toLocaleString(
                                            'id-ID'
                                        )
                                    }}
                                </td>
                                <td>
                                    {{ installment.installment_left }}
                                </td>
                            </tr>
                        </tbody>
                    </n-table>
                </template>
                <template #footer>
                    <n-space justify="space-between">
                        <div>
                            <p>Keterangan:</p>
                            <p>{{ installment?.note }}</p>
                        </div>
                        <n-card size="small">
                            <table class="w-64 font-bold">
                                <tr>
                                    <td>Angsuran Ke:</td>
                                    <td>
                                        {{ installment.installment_of }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jumlah Bayar:</td>
                                    <td>
                                        Rp.
                                        {{
                                            installment.transaction?.amount?.toLocaleString(
                                                'id-ID'
                                            )
                                        }}
                                    </td>
                                </tr>
                            </table>
                        </n-card>
                    </n-space>
                </template>
                <template #action>
                    <n-space
                        id="no-print"
                        justify="end">
                        <Link :href="route('admin.installment.index')">
                            <n-button type="primary"
                                >Kembali (Installment)
                            </n-button>
                        </Link>
                        <Link :href="route('admin.transactions.installment')">
                            <n-button type="primary"
                                >Kembali (Data Transaksi)
                            </n-button>
                        </Link>
                        <n-button
                            type="info"
                            @click="printPDF">
                            Print
                        </n-button>
                    </n-space>
                </template>
            </n-card>
        </template>
    </admin-layout>
</template>
