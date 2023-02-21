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
    NSelect,
    FormRules,
    NInput,
    NAutoComplete,
    FormInst,
    NElement,
    NUpload,
    NInputNumber,
} from 'naive-ui';
import { SelectMixedOption } from 'naive-ui/es/select/src/interface';
import route from 'ziggy-js';

const active = 'user-data';

const formRef = ref<FormInst | null>(null);

const form = useForm({
    picture: undefined,
    name: '',
    age: null,
    gender: null,
    occupation: null,
    address: null,
    contact: null,
    email: '',
    password: '',
    role: null,
});

const formRules: FormRules = {
    name: [
        {
            required: true,
            message: 'Nama diperlukan',
            trigger: ['input', 'blur'],
        },
    ],
    age: [
        {
            type: 'number',
            required: true,
            message: 'Usia diperlukan',
            trigger: ['input', 'blur'],
        },
        {
            type: 'number',
            message: 'Hanya menerima angka',
            trigger: 'blur',
        },
    ],
    gender: [
        {
            required: true,
            message: 'Jenis Kelamin diperlukan',
            trigger: ['input', 'blur'],
        },
    ],
    occupation: [
        {
            required: true,
            message: 'Pekerjaan diperlukan',
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
    email: [
        {
            required: true,
            message: 'Email diperlukan',
            trigger: ['input', 'blur'],
        },
        {
            type: 'email',
            message: 'Hanya menerima email',
            trigger: 'blur',
        },
    ],
    password: [
        {
            required: true,
            message: 'Password diperlukan',
            trigger: ['input', 'blur'],
        },
        {
            min: 8,
            message: 'Minimal 8 karakter',
            trigger: ['input', 'blur'],
        },
        {
            max: 24,
            message: 'Maksimal 24 karakter',
            trigger: ['input', 'blur'],
        },
    ],
    role: [
        {
            required: true,
            message: 'Role diperlukan',
            trigger: 'blur',
        },
    ],
};

const genderOptions: SelectMixedOption[] = [
    {
        label: 'Laki-laki',
        value: 'Laki-laki',
    },
    {
        label: 'Perempuan',
        value: 'Perempuan',
    },
];

const roleOptions: SelectMixedOption[] = [
    {
        label: 'Anggota',
        value: 'anggota',
    },
    {
        label: 'Admin',
        value: 'admin',
    },
];

const emailOptions = (form: { email: string }) => {
    return [
        ['Google', '@gmail.com'],
        ['Yahoo', '@yahoo.com'],
        ['Outlook', '@outlook.com'],
    ].map((emailInfo) => {
        return {
            type: 'group',
            label: emailInfo[0],
            key: emailInfo[0],
            children: [form.email?.split('@')[0] + emailInfo[1]],
        };
    });
};

const submitForm = () => {
    formRef.value?.validate((errors) => {
        if (!errors) {
            form.post(route('admin.users.store'));
        }
    });
};
</script>
<template layout="default">
    <Head>
        <title>Admin | Anggota Baru</title>
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
                <n-h1 align="center">Anggota Baru</n-h1>
                <Link :href="route('admin.users.index')">
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
                            path="picture"
                            label="Foto Profil">
                            <n-upload
                                v-model:file-list="form.picture"
                                accept="image/*"
                                list-type="image-card"
                                :max="1" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.picture"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.picture }}
                        </n-element>
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
                            path="age"
                            label="Usia">
                            <n-input-number
                                v-model:value="form.age"
                                :min="0"
                                placeholder="Usia"
                                style="display: flex; flex: 1">
                                <template #suffix> Tahun</template>
                            </n-input-number>
                        </n-form-item>
                        <n-element
                            v-if="form.errors.age"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.age }}
                        </n-element>
                        <n-form-item
                            path="gender"
                            label="Jenis Kelamin">
                            <n-select
                                v-model:value="form.gender"
                                filterable
                                :options="genderOptions"
                                placeholder="Jenis Kelamin" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.gender"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.gender }}
                        </n-element>
                        <n-form-item
                            path="occupation"
                            label="Pekerjaan">
                            <n-input
                                v-model:value="form.occupation"
                                placeholder="Pekerjaan" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.occupation"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.occupation }}
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
                        <n-form-item
                            path="email"
                            label="Email">
                            <n-auto-complete
                                v-model:value="form.email"
                                :options="emailOptions(form)"
                                placeholder="Email Pengguna"
                                type="text">
                            </n-auto-complete>
                        </n-form-item>
                        <n-element
                            v-if="form.errors.email"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.email }}
                        </n-element>
                        <n-form-item
                            path="password"
                            label="Password">
                            <n-input
                                v-model:value="form.password"
                                placeholder="Password Pengguna"
                                show-password-on="click"
                                type="password" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.password"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.password }}
                        </n-element>
                        <n-form-item
                            path="role"
                            label="Role">
                            <n-select
                                v-model:value="form.role"
                                filterable
                                :options="roleOptions"
                                placeholder="Role Pengguna" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.role"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.role }}
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
