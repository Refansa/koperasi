<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import { WithdrawProperties } from '@/scripts/composables/model';
import { NCard, NSpace, NButton } from 'naive-ui';
import KoperasiLogo from '@/views/components/koperasi-logo.vue';
import dayjs from 'dayjs';
import route from 'ziggy-js';

const props = defineProps<{ withdraw: WithdrawProperties }>();

function printPDF() {
    window.open(route('admin.withdraw.print', props.withdraw.id));
}

const active = 'withdraw';
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
                                dayjs(withdraw.created_at).format(
                                    'YYYY-MM-DD HH:mm:ss'
                                )
                            }}</span
                        >
                    </n-space>
                </template>
                <template #default>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
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
                                {{ withdraw.user?.name }}
                            </p>
                            <p>Email: {{ withdraw.user?.email }}</p>
                            <p>Kontak: {{ withdraw.user?.contact }}</p>
                        </div>
                        <div>
                            <h3 class="font-black">
                                No Transaksi# T-{{ withdraw.id }}
                            </h3>
                            <p>
                                <span class="font-black">ID User:</span>
                                {{ withdraw.user?.id }}
                            </p>
                        </div>
                    </div>
                </template>
                <template #footer>
                    <n-space justify="end">
                        <n-card size="small">
                            <table class="w-64">
                                <tr class="font-bold">
                                    <td>Jenis Simpanan:</td>
                                    <td>{{ withdraw.type }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Jumlah tarik:</td>
                                    <td>
                                        Rp.
                                        {{
                                            withdraw.transaction?.amount?.toLocaleString(
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
                        <Link :href="route('admin.withdraw.index')">
                            <n-button type="primary"
                                >Kembali (Withdraw)
                            </n-button>
                        </Link>
                        <Link :href="route('admin.transactions.withdraw')">
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
