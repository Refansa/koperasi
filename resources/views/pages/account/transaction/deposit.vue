<script setup lang="ts">
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import UserLayout from '@/views/layouts/user-layout.vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import UserMenu from '@/views/components/user/user-menu.vue';
import route from 'ziggy-js';

import { useAuth } from '@/scripts/composables/auth';

import {
    NH1,
    NSpace,
    NCard,
    NForm,
    FormInst,
    NAlert,
    FormRules,
    NSelect,
    NButton,
    NFormItem,
    NElement,
    NInputNumber,
} from 'naive-ui';
import { SelectMixedOption } from 'naive-ui/es/select/src/interface';

import { UserProperties, SettingProperties } from '@/scripts/composables/model';

const active = 'deposit';

const props = defineProps<{
    user: UserProperties;
    setting: SettingProperties;
    has_mandatory: boolean;
}>();

const auth = useAuth();

interface FormProperties {
    user_id: number | null;
    amount: number | null;
    type: string | null;
}

const formRef = ref<FormInst | null>(null);

const form = useForm<FormProperties>({
    user_id: auth.user.id,
    amount: null,
    type: null,
});

const typeOptions: SelectMixedOption[] = [
    {
        label: 'Pokok',
        value: 'Pokok',
        disabled:
            (props?.user.m_saving?.basic_amount ?? 0) >=
            props.setting.minimum_basic_cost,
    },
    {
        label: 'Wajib',
        value: 'Wajib',
        disabled: !props.has_mandatory,
    },
    {
        label: 'Sukarela',
        value: 'Sukarela',
        disabled:
            (props.user?.m_saving?.basic_amount ?? 0) <
            props.setting.minimum_basic_cost,
    },
    {
        label: 'Donasi',
        value: 'Donasi',
        disabled:
            (props.user?.m_saving?.basic_amount ?? 0) <
            props.setting.minimum_basic_cost,
    },
];

const formRules: FormRules = {
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
    type: [
        {
            required: true,
            message: 'Jenis Simpanan diperlukan',
            trigger: ['blur', 'change'],
        },
    ],
};

const submitForm = () => {
    formRef.value?.validate((errors) => {
        if (!errors) {
            form.post(route('account.deposit.payment'));
        }
    });
};

const autoAmount = (v: string) => {
    if (v === 'Pokok') {
        form.amount = props.setting.minimum_basic_cost;
    } else if (v === 'Wajib') {
        form.amount = props.setting.minimum_mandatory_cost;
    }
};
</script>
<template layout="default">
    <Head>
        <title>Simpan</title>
    </Head>
    <user-layout>
        <template #header>
            <navbar />
        </template>
        <template #sidebar>
            <user-menu :active="active"></user-menu>
        </template>
        <template #default>
            <n-space vertical>
                <n-h1 align="center">Transaksi Simpan</n-h1>
                <n-card class="lg:py-10 lg:px-20">
                    <n-space vertical>
                        <n-alert
                            v-if="
                                (user.m_saving?.basic_amount ?? 0) <
                                setting.minimum_basic_cost
                            "
                            type="warning"
                            title="Anda Belum Mempunyai Simpanan Pokok">
                            Simpanan Pokok dibutuhkan sebelum memilih opsi
                            simpanan lain.
                        </n-alert>
                        <n-alert
                            v-else-if="has_mandatory"
                            type="warning"
                            title="Anda Belum Membayar Simpanan Wajib Bulan Ini"></n-alert>
                        <n-form
                            ref="formRef"
                            size="large"
                            :model="form"
                            :rules="formRules"
                            @submit.prevent="submitForm">
                            <n-form-item
                                path="type"
                                label="Jenis Simpanan">
                                <n-select
                                    v-model:value="form.type"
                                    @update:value="autoAmount"
                                    filterable
                                    :options="typeOptions"
                                    placeholder="Pilih Jenis Simpanan" />
                            </n-form-item>
                            <n-element
                                v-if="form.errors.type"
                                class="text-[var(--error-color)] mb-6">
                                {{ form.errors.type }}
                            </n-element>
                            <n-form-item
                                path="amount"
                                label="Jumlah Simpanan">
                                <n-input-number
                                    v-model:value="form.amount"
                                    :min="0"
                                    placeholder="Jumlah Simpanan"
                                    style="display: flex; flex: 1">
                                    <template #prefix> Rp. </template>
                                </n-input-number>
                            </n-form-item>
                            <n-element
                                v-if="form.errors.amount"
                                class="text-[var(--error-color)] mb-6">
                                {{ form.errors.amount }}
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
                    </n-space>
                </n-card>
            </n-space>
        </template>
    </user-layout>
</template>
