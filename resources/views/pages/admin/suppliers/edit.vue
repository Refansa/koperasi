<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import { SupplierProperties } from '@/scripts/composables/model';
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

const props = defineProps<{ supplier: SupplierProperties }>();

const formRef = ref<FormInst | null>(null);

const form = useForm({
    name: props.supplier.name,
    address: props.supplier.address,
    contact: props.supplier.contact,
});

const formRules: FormRules = {
    name: [
        {
            required: true,
            message: 'Nama diperlukan',
            trigger: ['input', 'blur'],
        },
    ],
    address: [
        {
            required: true,
            message: 'Alamat diperlukan',
            trigger: ['input', 'blur'],
        },
    ],
    contact: [
        {
            required: true,
            message: 'Kontak diperlukan',
            trigger: ['input', 'blur'],
        },
    ],
};

const submitForm = () => {
    formRef.value?.validate((errors) => {
        if (!errors) {
            form.put(route('admin.suppliers.update', props.supplier.id));
        }
    });
};

const active = 'supplier-data';
</script>
<template layout="default">
    <Head>
        <title>Admin | Edit Supplier</title>
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
                <n-h1 align="center">Edit Supplier</n-h1>
                <Link :href="route('admin.suppliers.index')">
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
                            path="name"
                            label="Nama">
                            <n-input
                                v-model:value="form.name"
                                placeholder="Nama Pengguna" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.name"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.name }}
                        </n-element>
                        <n-form-item
                            path="address"
                            label="Alamat">
                            <n-input
                                v-model:value="form.address"
                                placeholder="Alamat Pengguna" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.address"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.address }}
                        </n-element>
                        <n-form-item
                            path="contact"
                            label="Kontak">
                            <n-input
                                v-model:value="form.contact"
                                placeholder="Kontak Pengguna" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.contact"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.contact }}
                        </n-element>
                        <n-button
                            :disabled="form.processing"
                            :loading="form.processing"
                            attr-type="submit"
                            size="large"
                            block
                            type="success"
                            >Edit
                        </n-button>
                    </n-form>
                </n-card>
            </n-space>
        </template>
    </admin-layout>
</template>
