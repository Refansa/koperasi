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
    NInputNumber,
    NInput,
    NAlert,
} from 'naive-ui';
import { SelectMixedOption } from 'naive-ui/es/select/src/interface';
import route from 'ziggy-js';

const props = defineProps<{
    loans: LoanProperties[];
}>();

const active = 'installment';

const formRef = ref<FormInst | null>(null);

interface FormProperties {
    loan_id: number | null;
    amount: number | null;
    installment_of: number | null;
}

const form = useForm<FormProperties>({
    loan_id: null,
    amount: null,
    installment_of: null,
});

const loanOptions: SelectMixedOption[] = props.loans.map((v) => {
    return {
        label: `P-${v.id} | ${v.user?.name} (Rp. ${(
            (v.transaction?.amount ?? 0) +
            ((v.transaction?.amount ?? 0) * (v.interest * v.loan_period)) / 100
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
        <title>Admin | Simpan</title>
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
                        <n-form-item
                            path="amount"
                            :label="`Jumlah Angsuran`">
                            <n-input-number
                                v-model:value="form.amount"
                                :min="0"
                                disabled
                                placeholder="Jumlah Angsuran"
                                style="display: flex; flex: 1">
                                <template #prefix> Rp. </template>
                            </n-input-number>
                        </n-form-item>
                        <n-element
                            v-if="form.errors.amount"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.amount }}
                        </n-element>
                        <n-form-item
                            path="installment_of"
                            label="Angsuran Ke:">
                            <n-input-number
                                v-model:value="form.installment_of"
                                :min="0"
                                disabled
                                placeholder="Angsuran Ke-?"
                                style="display: flex; flex: 1">
                            </n-input-number>
                        </n-form-item>
                        <n-element
                            v-if="form.errors.installment_of"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.installment_of }}
                        </n-element>
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
