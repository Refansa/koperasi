<script setup lang="ts">
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
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
    NElement,
    NSelect,
    NTable,
    NInput,
} from 'naive-ui';
import { SelectMixedOption } from 'naive-ui/es/select/src/interface';
import route from 'ziggy-js';

const props = defineProps<{
    loans: LoanProperties[];
}>();

const active = 'installment';

const formRef = ref<FormInst | null>(null);

const loanRef = ref<LoanProperties | null>(null);

interface FormProperties {
    loan_id: number | null;
    amount: number | null;
    installment_of: number | null;
    note: string | null;
}

const form = useForm<FormProperties>({
    loan_id: null,
    amount: null,
    installment_of: null,
    note: null,
});

const loanOptions: SelectMixedOption[] = props.loans.map((v) => {
    return {
        label: `P-${v.id} | ${v.user?.name} (Rp. ${(
            v.transaction?.amount ?? 0
        ).toLocaleString('id-ID')})`,
        value: v.id,
    } as SelectMixedOption;
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
            form.post(route('admin.installment.store'));
        }
    });
};

const autoFill = (v: number) => {
    const loan = props.loans.filter((l) => l.id === v)[0];
    loanRef.value = loan;
    form.amount =
        ((loan.transaction?.amount ?? 0) +
            ((loan.transaction?.amount ?? 0) *
                (loan.interest * loan.loan_period)) /
                100) /
        loan.loan_period;
    form.installment_of = loan.installment_tracker?.installment_of ?? 1;
};
</script>
<template layout="default">
    <Head>
        <title>Admin | Angsuran</title>
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
                <n-h1 align="center">Angsuran</n-h1>
                <n-card class="lg:py-10 lg:px-20">
                    <n-form
                        ref="formRef"
                        size="large"
                        :model="form"
                        :rules="formRules"
                        @submit.prevent="submitForm">
                        <n-form-item
                            path="loan_id"
                            label="ID Pinjaman">
                            <n-select
                                v-model:value="form.loan_id"
                                @update:value="autoFill"
                                filterable
                                :options="loanOptions"
                                placeholder="Pilih ID Pinjaman" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.loan_id"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.loan_id }}
                        </n-element>
                        <div
                            class="mb-10"
                            v-if="loanRef">
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
                                        <td>{{ loanRef.user?.id }}</td>
                                        <td>{{ loanRef.user?.name }}</td>
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
                                                loanRef?.installment_tracker
                                                    .installment_of == 1
                                                    ? loanRef
                                                          ?.installment_tracker
                                                          .installment_needed
                                                    : loanRef
                                                          ?.installment_tracker
                                                          .installment_needed +
                                                      1 -
                                                      loanRef
                                                          ?.installment_tracker
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
                                                loanRef.installment_tracker
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
                </n-card>
            </n-space>
        </template>
    </admin-layout>
</template>
