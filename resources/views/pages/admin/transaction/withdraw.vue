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
} from 'naive-ui';
import { SelectMixedOption } from 'naive-ui/es/select/src/interface';
import route from 'ziggy-js';

const props = defineProps<{ users: UserProperties[] }>();

const active = 'withdraw';

const formRef = ref<FormInst | null>(null);

const form = useForm<{
    user_id: number | null;
    amount: number | null;
}>({
    user_id: null,
    amount: null,
});

const withdrawLimit = () => {
    if (form.user_id) {
        return (
            props.users.filter((u) => u.id === form.user_id)[0].m_saving
                ?.deposit_amount ?? 0
        );
    }
    return 0;
};

const userOptions: SelectMixedOption[] = props.users.map((v) => {
    return {
        label: `${v.name} - (${v.email})`,
        value: v.id,
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
};

const submitForm = () => {
    formRef.value?.validate((errors) => {
        if (!errors) {
            form.post(route('admin.withdraw.store'));
        }
    });
};
</script>
<template layout="default">
    <Head>
        <title>Admin | Tarik</title>
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
                <n-h1 align="center">Tarik</n-h1>
                <n-card>
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
                            :label="`Jumlah Ditarik (Saldo: ${withdrawLimit()})`">
                            <n-input-number
                                v-model:value="form.amount"
                                :min="0"
                                :max="withdrawLimit()"
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
