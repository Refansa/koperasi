<script setup lang="ts">
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import UserLayout from '@/views/layouts/user-layout.vue';
import UserMenu from '@/views/components/user/user-menu.vue';
import { LoanProperties } from '@/scripts/composables/model';
import {
    NSpace,
    NButton,
    NH1,
    NForm,
    NCard,
    NFormItem,
    FormRules,
    FormInst,
    NTable,
    NInput,
    NAlert,
} from 'naive-ui';
import route from 'ziggy-js';

const props = defineProps<{
    loan: LoanProperties | null;
}>();

const active = 'installment';

const formRef = ref<FormInst | null>(null);

interface FormProperties {
    loan_id: number | null;
    amount: number | null;
    installment_of: number | null;
    note: string | null;
}

const form = useForm<FormProperties>({
    loan_id: props.loan?.id ?? null,
    amount:
        ((props.loan?.transaction?.amount ?? 0) +
            ((props.loan?.transaction?.amount ?? 0) *
                ((props.loan?.interest ?? 0) *
                    (props.loan?.loan_period ?? 0))) /
                100) /
            (props.loan?.loan_period ?? 0) ?? null,
    installment_of: props.loan?.installment_tracker?.installment_of ?? 1,
    note: null,
});

const formRules: FormRules = {
    loan_id: [
        {
            type: 'number',
            required: true,
            message: 'ID Peminjaman diperlukan',
            trigger: ['input', 'blur'],
        },
    ],
    amount: [
        {
            type: 'number',
            required: true,
            message: 'Jumlah Angsuran diperlukan',
            trigger: ['input', 'blur'],
        },
        {
            type: 'number',
            message: 'Hanya menerima angka',
            trigger: 'blur',
        },
    ],
    installment_of: [
        {
            type: 'number',
            required: true,
            message: 'Angsuran Ke diperlukan',
            trigger: ['input', 'blur'],
        },
        {
            type: 'number',
            message: 'Hanya menerima angka',
            trigger: 'blur',
        },
    ],
};

const submitForm = () => {
    formRef.value?.validate((errors) => {
        if (!errors) {
            form.post(route('account.installment.payment'));
        }
    });
};
</script>
<template layout="default">
    <Head>
        <title>Transaksi Angsuran</title>
    </Head>
    <user-layout>
        <template #header>
            <navbar />
        </template>
        <template #sidebar>
            <user-menu :active="active" />
        </template>
        <template #default>
            <n-space vertical>
                <n-h1 align="center">Transaksi Angsuran</n-h1>
                <n-alert
                    title="Perhatian"
                    type="warning">
                    Angsuran yang memiliki koma dibelakang akan dibulatkan ke
                    bilangan bulat atas terdekat.
                </n-alert>
                <n-card class="lg:py-10 lg:px-20">
                    <n-form
                        v-if="loan"
                        ref="formRef"
                        size="large"
                        :model="form"
                        :rules="formRules"
                        @submit.prevent="submitForm">
                        <div class="mb-10">
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
                                        <td>P-{{ form.loan_id }}</td>
                                        <td>{{ loan.user?.id }}</td>
                                        <td>{{ loan.user?.name }}</td>
                                        <td>
                                            Rp.
                                            {{
                                                form.amount?.toLocaleString(
                                                    'id-ID'
                                                )
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                loan?.installment_tracker
                                                    .installment_of == 1
                                                    ? loan?.installment_tracker
                                                          .installment_needed
                                                    : loan?.installment_tracker
                                                          .installment_needed +
                                                      1 -
                                                      loan?.installment_tracker
                                                          .installment_of
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                            </n-table>
                            <n-space
                                class="mt-4"
                                align="center"
                                justify="space-between">
                                <n-form-item label="Keterangan">
                                    <n-input
                                        type="textarea"
                                        v-model:value="form.note"
                                        placeholder="Keterangan (Optional)" />
                                </n-form-item>
                                <n-table class="font-bold">
                                    <tr>
                                        <td>Angsuran Ke:</td>
                                        <td>
                                            {{
                                                loan.installment_tracker
                                                    .installment_of
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Bayar:</td>
                                        <td>
                                            Rp.
                                            {{
                                                form.amount?.toLocaleString(
                                                    'id-ID'
                                                )
                                            }}
                                        </td>
                                    </tr>
                                </n-table>
                            </n-space>
                        </div>
                        <n-button
                            :disabled="form.processing"
                            :loading="form.processing"
                            attr-type="submit"
                            size="large"
                            block
                            type="success"
                            >Bayar
                        </n-button>
                    </n-form>
                    <n-alert
                        v-else
                        title="Tidak Ada Peminjaman">
                        Anda tidak memiliki peminjaman yang aktif.
                    </n-alert>
                </n-card>
            </n-space>
        </template>
    </user-layout>
</template>
