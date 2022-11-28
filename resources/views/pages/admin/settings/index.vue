<script setup lang="ts">
import { Head, useForm } from '@inertiajs/inertia-vue3';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import {
    NSpace,
    NH1,
    NCard,
    NForm,
    NButton,
    NFormItem,
    NElement,
    NInputNumber,
    FormInst,
    FormRules,
} from 'naive-ui';
import { ref } from 'vue';
import { SettingProperties } from '@/scripts/composables/model';
import route from 'ziggy-js';

const props = defineProps<{ setting: SettingProperties }>();

const active = 'settings';

const formRef = ref<FormInst | null>(null);

const form = useForm({
    minimum_basic_cost: props.setting.minimum_basic_cost,
    minimum_mandatory_cost: props.setting.minimum_mandatory_cost,
    maximum_loan_amount: props.setting.maximum_loan_amount,
    saving_limit_for_loan: props.setting.saving_limit_for_loan,
});

const formRules: FormRules = {
    minimum_basic_cost: [
        {
            type: 'number',
            required: true,
            message: 'Biaya Pokok Minimal diperlukan',
            trigger: ['input', 'blur'],
        },
        {
            type: 'number',
            message: 'Hanya menerima angka',
            trigger: 'blur',
        },
    ],
    minimum_mandatory_cost: [
        {
            type: 'number',
            required: true,
            message: 'Biaya Wajib Minimal diperlukan',
            trigger: ['input', 'blur'],
        },
        {
            type: 'number',
            message: 'Hanya menerima angka',
            trigger: 'blur',
        },
    ],
    maximum_loan_amount: [
        {
            type: 'number',
            required: true,
            message: 'Jumlah Pinjaman Maksimal diperlukan',
            trigger: ['input', 'blur'],
        },
        {
            type: 'number',
            message: 'Hanya menerima angka',
            trigger: 'blur',
        },
    ],
    saving_limit_for_loan: [
        {
            type: 'number',
            required: true,
            message: 'Batas Tabungan Untuk Peminjaman diperlukan',
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
            form.post(route('admin.settings.update'));
        }
    });
};
</script>
<template layout="default">
    <Head>
        <title>Admin | Pengaturan</title>
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
                <n-h1 class="text-center">Pengaturan</n-h1>
                <n-card class="lg:py-10 lg:px-20">
                    <n-form
                        ref="formRef"
                        size="large"
                        :model="form"
                        :rules="formRules"
                        @submit.prevent="submitForm">
                        <n-form-item
                            path="minimum_basic_cost"
                            label="Biaya Pokok Minimal">
                            <n-input-number
                                v-model:value="form.minimum_basic_cost"
                                :min="0"
                                placeholder="Biaya pokok minimal"
                                style="display: flex; flex: 1">
                                <template #prefix> Rp. </template>
                            </n-input-number>
                        </n-form-item>
                        <n-element
                            v-if="form.errors.minimum_basic_cost"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.minimum_basic_cost }}
                        </n-element>
                        <n-form-item
                            path="minimum_mandatory_cost"
                            label="Biaya Wajib Minimal">
                            <n-input-number
                                v-model:value="form.minimum_mandatory_cost"
                                :min="0"
                                placeholder="Biaya wajib minimal"
                                style="display: flex; flex: 1">
                                <template #prefix> Rp. </template>
                            </n-input-number>
                        </n-form-item>
                        <n-element
                            v-if="form.errors.minimum_mandatory_cost"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.minimum_mandatory_cost }}
                        </n-element>
                        <n-form-item
                            path="maximum_loan_amount"
                            label="Jumlah Pinjaman Maksimal">
                            <n-input-number
                                v-model:value="form.maximum_loan_amount"
                                :min="0"
                                placeholder="Jumlah pinjaman maksimal"
                                style="display: flex; flex: 1">
                                <template #prefix> Rp. </template>
                            </n-input-number>
                        </n-form-item>
                        <n-element
                            v-if="form.errors.maximum_loan_amount"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.maximum_loan_amount }}
                        </n-element>
                        <n-form-item
                            path="saving_limit_for_loan"
                            label="Batas Tabungan Untuk Peminjaman">
                            <n-input-number
                                v-model:value="form.saving_limit_for_loan"
                                :min="0"
                                placeholder="Batas tabungan untuk peminjaman"
                                style="display: flex; flex: 1">
                                <template #prefix> Rp. </template>
                            </n-input-number>
                        </n-form-item>
                        <n-element
                            v-if="form.errors.saving_limit_for_loan"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.saving_limit_for_loan }}
                        </n-element>
                        <n-button
                            :disabled="form.processing"
                            :loading="form.processing"
                            attr-type="submit"
                            size="large"
                            block
                            type="success"
                            >Simpan perubahan
                        </n-button>
                    </n-form>
                </n-card>
            </n-space>
        </template>
    </admin-layout>
</template>
