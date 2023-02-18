<script setup lang="ts">
import { Head, useForm } from '@inertiajs/inertia-vue3';
import Navbar from '@/views/components/navbar/navbar.vue';
import UserLayout from '@/views/layouts/user-layout.vue';
import UserMenu from '@/views/components/user/user-menu.vue';
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
    UploadFileInfo,
    NAvatar,
    NTag,
} from 'naive-ui';
import { SelectMixedOption } from 'naive-ui/es/select/src/interface';
import { ref } from 'vue';
import { UserProperties } from '@/scripts/composables/model';
import route from 'ziggy-js';

const props = defineProps<{ user: UserProperties }>();

const active = 'settings';

const formRef = ref<FormInst | null>(null);

const default_picture: UploadFileInfo[] = [
    {
        id: 'file',
        name: 'profile',
        status: 'finished',
        url: props.user.picture,
    },
];

const form = useForm({
    oldPicture: props.user.picture,
    picture: default_picture,
    name: props.user.name,
    age: props.user.age,
    gender: props.user.gender,
    occupation: props.user.occupation,
    address: props.user.address,
    contact: props.user.contact,
    email: props.user.email as string,
    password: '',
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
            form.post(route('account.settings.update', props.user.id));
        }
    });
};
</script>
<template layout="default">
    <Head>
        <title>Pengaturan Akun</title>
    </Head>
    <user-layout>
        <template #header>
            <navbar />
        </template>
        <template #sidebar>
            <user-menu :active="active"> </user-menu>
        </template>
        <template #default>
            <n-space vertical>
                <n-h1 align="center">Pengaturan Akun</n-h1>
                <div class="flex gap-8">
                    <div class="w-1/3">
                        <n-card
                            class="w-full"
                            title="Preview">
                            <n-space
                                vertical
                                align="center"
                                justify="center">
                                <n-avatar
                                    bordered
                                    :size="72"
                                    object-fit="cover"
                                    round
                                    :src="
                                        user?.picture ??
                                        '/images/default-profile.jpg'
                                    " />
                                <div class="flex flex-col items-center">
                                    <h3 class="font-bold text-xl">
                                        {{ form.name }}
                                    </h3>
                                </div>
                            </n-space>
                            <n-space
                                vertical
                                align="center"
                                justify="center">
                                <n-text depth="3">{{ form.email }}</n-text>
                                <n-tag :bordered="false">{{ user.role }}</n-tag>
                            </n-space>
                            <n-space vertical>
                                <div class="flex flex-col">
                                    <n-text>Usia:</n-text>
                                    <n-text>{{ form.age }} Tahun</n-text>
                                </div>
                                <div class="flex flex-col">
                                    <n-text>Jenis Kelamin:</n-text>
                                    <n-text>{{ form.gender }}</n-text>
                                </div>
                                <div class="flex flex-col">
                                    <n-text>Alamat:</n-text>
                                    <n-text>{{ form.address }}</n-text>
                                </div>
                                <div class="flex flex-col">
                                    <n-text>Kontak:</n-text>
                                    <n-text>{{ form.contact }}</n-text>
                                </div>
                            </n-space>
                        </n-card>
                    </div>
                    <div class="w-2/3">
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
                                        :default-upload="true"
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
                    </div>
                </div>
            </n-space>
        </template>
    </user-layout>
</template>
