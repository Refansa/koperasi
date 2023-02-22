<script setup lang="ts">
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import { UserProperties } from '@/scripts/composables/model';
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
    useDialog,
} from 'naive-ui';
import { SelectMixedOption } from 'naive-ui/es/select/src/interface';
import route from 'ziggy-js';

const props = defineProps<{ users: UserProperties[] }>();

const active = 'withdraw';

const formRef = ref<FormInst | null>(null);

interface FormProperties {
    user_id: number | null;
    type: string | null;
    amount: number | null;
}

const form = useForm<FormProperties>({
    user_id: null,
    type: null,
    amount: null,
});

const withdrawLimit = ref(0);

const getWithdrawLimit = (v: string | number) => {
    if (typeof v === 'string') {
        if (form.user_id) {
            switch (v) {
                case 'Pokok':
                    withdrawLimit.value =
                        props.users.filter((u) => u.id === form.user_id)[0]
                            .m_saving?.basic_amount ?? 0;
                    break;
                case 'Wajib':
                    withdrawLimit.value =
                        props.users.filter((u) => u.id === form.user_id)[0]
                            .m_saving?.mandatory_amount ?? 0;
                    break;
                case 'Sukarela':
                    withdrawLimit.value =
                        props.users.filter((u) => u.id === form.user_id)[0]
                            .m_saving?.voluntary_amount ?? 0;
                    break;
                case 'Semua':
                    const basic =
                        props.users.filter((u) => u.id === form.user_id)[0]
                            .m_saving?.basic_amount ?? 0;
                    const mandatory =
                        props.users.filter((u) => u.id === form.user_id)[0]
                            .m_saving?.mandatory_amount ?? 0;
                    const voluntary =
                        props.users.filter((u) => u.id === form.user_id)[0]
                            .m_saving?.voluntary_amount ?? 0;

                    withdrawLimit.value = basic + mandatory + voluntary;
                    form.amount = withdrawLimit.value;
                    break;
                default:
                    withdrawLimit.value = 0;
                    break;
            }
        }
    }
    if (typeof v === 'number') {
        if (form.type) {
            switch (form.type) {
                case 'Pokok':
                    withdrawLimit.value =
                        props.users.filter((u) => u.id === v)[0].m_saving
                            ?.basic_amount ?? 0;
                    break;
                case 'Wajib':
                    withdrawLimit.value =
                        props.users.filter((u) => u.id === v)[0].m_saving
                            ?.mandatory_amount ?? 0;
                    break;
                case 'Sukarela':
                    withdrawLimit.value =
                        props.users.filter((u) => u.id === v)[0].m_saving
                            ?.voluntary_amount ?? 0;
                    break;
                case 'Semua':
                    const basic =
                        props.users.filter((u) => u.id === v)[0].m_saving
                            ?.basic_amount ?? 0;
                    const mandatory =
                        props.users.filter((u) => u.id === v)[0].m_saving
                            ?.mandatory_amount ?? 0;
                    const voluntary =
                        props.users.filter((u) => u.id === v)[0].m_saving
                            ?.voluntary_amount ?? 0;

                    withdrawLimit.value = basic + mandatory + voluntary;
                    form.amount = withdrawLimit.value;
                    break;
                default:
                    withdrawLimit.value = 0;
                    break;
            }
        }
    }
    return 0;
};

const userOptions: SelectMixedOption[] = props.users.map((v) => {
    return {
        label: `${v.name} - (${v.email})`,
        value: v.id,
    } as SelectMixedOption;
});

const typeOptions: SelectMixedOption[] = [
    'Pokok',
    'Wajib',
    'Sukarela',
    'Semua',
].map((v) => {
    return {
        label: v,
        value: v,
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
    type: [
        {
            required: true,
            message: 'Jenis Simpanan diperlukan',
            trigger: ['blur', 'change'],
        },
    ],
};

const dialog = useDialog();

const submitForm = () => {
    if (form.type === 'Semua') {
        dialog.warning({
            title: 'Konfirmasi',
            content: 'Apa anda yakin ingin menarik semua saldo anggota ini?',
            positiveText: 'Tarik',
            negativeText: 'Batal',
            onPositiveClick: () => {
                formRef.value?.validate((errors) => {
                    if (!errors) {
                        form.post(route('admin.withdraw.store'));
                    }
                });
            },
        });
    } else {
        formRef.value?.validate((errors) => {
            if (!errors) {
                form.post(route('admin.withdraw.store'));
            }
        });
    }
};
</script>
<template layout="default">
    <Head>
        <title>Admin | Transaksi Tarik</title>
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
                <n-h1 align="center">Transaksi Tarik</n-h1>
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
                                @update:value="getWithdrawLimit"
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
                            path="type"
                            label="Jenis Simpanan">
                            <n-select
                                v-model:value="form.type"
                                @update:value="getWithdrawLimit"
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
                            :label="`Jumlah Ditarik (Saldo: ${withdrawLimit})`">
                            <n-input-number
                                v-model:value="form.amount"
                                :min="0"
                                :max="withdrawLimit"
                                :disabled="form.type === 'Semua'"
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
                        <n-button
                            :disabled="form.processing"
                            :loading="form.processing"
                            attr-type="submit"
                            size="large"
                            block
                            type="success"
                            >Tarik
                        </n-button>
                    </n-form>
                </n-card>
            </n-space>
        </template>
    </admin-layout>
</template>
