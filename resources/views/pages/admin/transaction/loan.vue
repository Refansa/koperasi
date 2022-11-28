<script setup lang="ts">
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import { UserProperties, SettingProperties } from '@/scripts/composables/model';
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
} from 'naive-ui';
import { SelectMixedOption } from 'naive-ui/es/select/src/interface';
import route from 'ziggy-js';

const props = defineProps<{
    users: UserProperties[];
    setting: SettingProperties;
}>();

const active = 'loan';

const formRef = ref<FormInst | null>(null);

interface FormProperties {
    user_id: number | null;
    amount: number | null;
    loan_period: number | null;
    interest: number | null;
    note: string | null;
}

const form = useForm<FormProperties>({
    user_id: null,
    amount: null,
    loan_period: null,
    interest: null,
    note: null,
});

const userOptions: SelectMixedOption[] = props.users.map((v) => {
    return {
        label: `${v.name} - (${v.email})`,
        value: v.id,
    } as SelectMixedOption;
});

const periodOptions: SelectMixedOption[] = [
    { label: '6 Bulan', value: 6 },
    { label: '12 Bulan', value: 12 },
    { label: '18 Bulan', value: 18 },
    { label: '24 Bulan', value: 24 },
    { label: '36 Bulan', value: 36 },
    { label: '48 Bulan', value: 48 },
].map((v) => {
    return {
        label: v.label,
        value: v.value,
    } as SelectMixedOption;
});

const formRules: FormRules = {
    user_id: [
        {
            type: 'number',
            required: true,
            message: 'Pengguna diperlukan',
            trigger: ['input', 'blur'],
        },
    ],
    amount: [
        {
            type: 'number',
            required: true,
            message: 'Jumlah diperlukan',
            trigger: ['input', 'blur'],
        },
        {
            type: 'number',
            message: 'Hanya menerima angka',
            trigger: 'blur',
        },
    ],
    loan_period: [
        {
            type: 'number',
            required: true,
            message: 'Tenor diperlukan',
            trigger: ['blur', 'change'],
        },
    ],
    interest: [
        {
            type: 'number',
            required: true,
            message: 'Bunga diperlukan',
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
            form.post(route('admin.loan.store'));
        }
    });
};

const autoInterest = (v: number) => {
    form.interest = v <= 24 ? 2 : 4;
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
                <n-h1 align="center">Simpan</n-h1>
                <n-card class="lg:py-10 lg:px-20">
                    <n-form
                        ref="formRef"
                        size="large"
                        :model="form"
                        :rules="formRules"
                        @submit.prevent="submitForm">
                        <n-form-item
                            path="user_id"
                            label="Pengguna">
                            <n-select
                                v-model:value="form.user_id"
                                filterable
                                :options="userOptions"
                                placeholder="Pilih Pengguna" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.user_id"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.user_id }}
                        </n-element>
                        <n-form-item
                            path="amount"
                            :label="`Jumlah (Maks: Rp. ${setting.maximum_loan_amount.toLocaleString(
                                'id-ID'
                            )})`">
                            <n-input-number
                                v-model:value="form.amount"
                                :min="0"
                                :max="setting.maximum_loan_amount"
                                placeholder="Jumlah"
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
                            path="loan_period"
                            label="Tenor">
                            <n-select
                                v-model:value="form.loan_period"
                                @update:value="autoInterest"
                                filterable
                                :options="periodOptions"
                                placeholder="Pilih" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.loan_period"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.loan_period }}
                        </n-element>
                        <n-form-item
                            path="interest"
                            label="Bunga % Per Bulan">
                            <n-input-number
                                v-model:value="form.interest"
                                :min="0"
                                placeholder="Dalam Persen %"
                                style="display: flex; flex: 1">
                                <template #suffix>%</template>
                            </n-input-number>
                        </n-form-item>
                        <n-element
                            v-if="form.errors.interest"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.interest }}
                        </n-element>
                        <n-form-item label="Note">
                            <n-input
                                v-model:value="form.note"
                                placeholder="Keterangan" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.note"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.note }}
                        </n-element>
                        <n-button
                            :disabled="form.processing"
                            :loading="form.processing"
                            attr-type="submit"
                            size="large"
                            block
                            type="success"
                            >Simpan
                        </n-button>
                    </n-form>
                </n-card>
            </n-space>
        </template>
    </admin-layout>
</template>
