<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import { LoanProperties } from '@/scripts/composables/model';
import { NCard, NSpace, NButton, NTable } from 'naive-ui';
import KoperasiLogo from '@/views/components/koperasi-logo.vue';
import dayjs from 'dayjs';
import route from 'ziggy-js';

const props = defineProps<{ loan: LoanProperties }>();

function printPDF() {
    window.open(route('admin.loan.print', props.loan.id));
}

const active = 'loan';
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
                                dayjs(loan.created_at).format(
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
                            <p class="font-black">Koperasi Sekolah</p>
                            <p>Alamat: Jl. Menuju Kesuksesan</p>
                            <p>Phone: (+62) 81234567890</p>
                            <p>Email: admin@koperasi.com</p>
                        </div>
                        <div>
                            <h3 class="underline">To:</h3>
                            <p class="font-black">
                                {{ loan.user?.name }}
                            </p>
                            <p>Email: {{ loan.user?.email }}</p>
                            <p>Kontak: {{ loan.user?.contact }}</p>
                        </div>
                        <div>
                            <h3 class="font-black">
                                No Transaksi# P-{{ loan.id }}
                            </h3>
                            <p>
                                <span class="font-black">ID User:</span>
                                {{ loan.user?.id }}
                            </p>
                        </div>
                    </div>
                    <n-table
                        :bordered="false"
                        :single-line="false">
                        <thead>
                            <tr>
                                <th>Jumlah Pinjam</th>
                                <th>Tenor</th>
                                <th>Bunga Per Bulan</th>
                                <th>Total #</th>
                                <th>Angsuran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Rp.
                                    {{
                                        (
                                            loan.transaction?.amount ?? 0
                                        ).toLocaleString('id-ID')
                                    }}
                                </td>
                                <td>{{ loan.loan_period }} Bulan</td>
                                <td>{{ loan.interest }}%</td>
                                <td>
                                    Rp.
                                    {{
                                        (
                                            (loan.transaction?.amount ?? 0) +
                                            ((loan.transaction?.amount ?? 0) *
                                                (loan.interest *
                                                    loan.loan_period)) /
                                                100
                                        ).toLocaleString('id-ID')
                                    }}
                                </td>
                                <td>
                                    Rp.
                                    {{
                                        (
                                            ((loan.transaction?.amount ?? 0) +
                                                ((loan.transaction?.amount ??
                                                    0) *
                                                    (loan.interest *
                                                        loan.loan_period)) /
                                                    100) /
                                            loan.loan_period
                                        ).toLocaleString('id-ID')
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </n-table>
                </template>
                <template #footer>
                    <n-space justify="space-between">
                        <div>
                            <p>Keterangan:</p>
                            <p>{{ loan.note }}</p>
                        </div>
                        <n-card size="small">
                            <table class="w-64">
                                <tr>
                                    <td class="font-bold">Jumlah Pinjam:</td>
                                    <td>
                                        Rp.
                                        {{
                                            loan.transaction?.amount?.toLocaleString(
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
                        <Link :href="route('admin.loan.index')">
                            <n-button type="primary">Kembali (Loan) </n-button>
                        </Link>
                        <Link :href="route('admin.transactions.loan')">
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
