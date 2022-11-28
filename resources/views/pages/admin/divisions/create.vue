<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import {
    NSpace,
    NButton,
    NH1,
    NForm,
    NCard,
    NFormItem,
    FormRules,
    NInput,
    FormInst,
    NElement,
} from 'naive-ui';
import route from 'ziggy-js';

const active = 'division-data';

const formRef = ref<FormInst | null>(null);

const form = useForm({
    position: null,
});

const formRules: FormRules = {
    position: [
        {
            required: true,
            message: 'Bagian diperlukan',
            trigger: ['input', 'blur'],
        },
    ],
};

const submitForm = () => {
    formRef.value?.validate((errors) => {
        if (!errors) {
            form.post(route('admin.divisions.store'));
        }
    });
};
</script>
<template layout="default">
    <Head>
        <title>Admin | Bagian Baru</title>
    </Head>
    <admin-layout>
        <template #header>
            <navbar type="admin" />
        </template>
        <template #sidebar>
            <admin-menu :active="active"> </admin-menu>
        </template>
        <template #default>
            <n-space vertical>
                <n-h1 align="center">Bagian Baru</n-h1>
                <Link :href="route('admin.divisions.index')">
                    <n-button type="primary">Kembali</n-button>
                </Link>
                <n-card class="lg:py-10 lg:px-20">
                    <n-form
                        ref="formRef"
                        size="large"
                        :model="form"
                        :rules="formRules"
                        @submit.prevent="submitForm">
                        <n-form-item
                            path="position"
                            label="Bagian">
                            <n-input
                                v-model:value="form.position"
                                placeholder="Bagian" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.position"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.position }}
                        </n-element>
                        <n-button
                            :disabled="form.processing"
                            :loading="form.processing"
                            attr-type="submit"
                            size="large"
                            block
                            type="success"
                            >Buat
                        </n-button>
                    </n-form>
                </n-card>
            </n-space>
        </template>
    </admin-layout>
</template>
