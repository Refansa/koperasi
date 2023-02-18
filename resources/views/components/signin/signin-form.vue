<script setup lang="ts">
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

import {
    NH1,
    NText,
    NForm,
    NInput,
    NButton,
    FormInst,
    NFormItem,
    FormRules,
    NCheckbox,
    FormItemRule,
    NAutoComplete,
    NInputNumber,
    NElement,
    NSelect,
} from 'naive-ui';

import route from 'ziggy-js';
import { SelectMixedOption } from 'naive-ui/es/select/src/interface';

defineProps<{ tab?: string }>();

const signInRef = ref<FormInst | null>(null);
const signUpRef = ref<FormInst | null>(null);

interface SignInType {
    email?: string;
    password?: string;
    rememberMe?: boolean;
}

interface SignUpType {
    email?: string;
    password?: string;
    reenteredPassword?: string;
    name?: string | null;
    age?: number | null;
    gender?: string | null;
    occupation?: string | null;
    address?: string | null;
    contact?: string | null;
}

const signInForm = useForm<SignInType>({
    email: '',
    password: '',
    rememberMe: false,
});

const signUpForm = useForm<SignUpType>({
    name: '',
    age: null,
    gender: null,
    occupation: null,
    address: null,
    contact: null,
    email: '',
    password: '',
    reenteredPassword: '',
});

function validatePasswordStartWith(rule: FormItemRule, value: string): boolean {
    return (
        !!signUpForm.password &&
        signUpForm.password.startsWith(value) &&
        signUpForm.password.length >= value.length
    );
}
function validatePasswordSame(rule: FormItemRule, value: string): boolean {
    return value === signUpForm.password;
}

const signInRules: FormRules = {
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
};

const signUpRules: FormRules = {
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
    reenteredPassword: [
        {
            required: true,
            message: 'Ulangi Password diperlukan',
            trigger: ['input', 'blur'],
        },
        {
            validator: validatePasswordStartWith,
            message: 'Password tidak sama dengan yang diulangi!',
            trigger: 'input',
        },
        {
            validator: validatePasswordSame,
            message: 'Password tidak sama dengan yang diulangi!',
            trigger: ['blur', 'password-input'],
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

const emailOptions = (model: SignInType | SignUpType) => {
    return [
        ['Google', '@gmail.com'],
        ['Yahoo', '@yahoo.com'],
        ['Outlook', '@outlook.com'],
    ].map((emailInfo) => {
        return {
            type: 'group',
            label: emailInfo[0],
            key: emailInfo[0],
            children: [model.email?.split('@')[0] + emailInfo[1]],
        };
    });
};

const signIn = () => {
    signInRef.value?.validate((errors) => {
        if (!errors) {
            signInForm.post(route('signin.post'));
        }
    });
};

const signUp = () => {
    signUpRef.value?.validate((errors) => {
        if (!errors) {
            signUpForm.post(route('signup.post'));
        }
    });
};
</script>
<template>
    <Transition
        :name="tab === 'signin' ? 'slide-right' : 'slide-left'"
        mode="out-in">
        <n-form
            v-if="tab === 'signin'"
            ref="signInRef"
            class="w-72 sm:w-80 lg:w-96"
            size="large"
            :model="signInForm"
            :rules="signInRules"
            @submit.prevent="signIn">
            <n-h1 class="text-center">Masuk</n-h1>
            <n-form-item
                path="email"
                label="Email">
                <n-auto-complete
                    v-model:value="signInForm.email"
                    :options="emailOptions(signInForm)"
                    placeholder="budi@contoh.com"
                    type="text">
                </n-auto-complete>
            </n-form-item>
            <n-form-item
                path="password"
                label="Password">
                <n-input
                    v-model:value="signInForm.password"
                    placeholder="Password"
                    show-password-on="click"
                    type="password" />
            </n-form-item>
            <div class="flex flex-col gap-4">
                <n-text
                    v-if="signInForm.errors.email"
                    type="error">
                    {{ signInForm.errors.email }}
                </n-text>
                <n-checkbox
                    v-model:checked="signInForm.rememberMe"
                    size="large"
                    >Remember Me</n-checkbox
                >
            </div>
            <div class="mt-8">
                <n-button
                    :disabled="signInForm.processing"
                    :loading="signInForm.processing"
                    attr-type="submit"
                    size="large"
                    block
                    type="success"
                    >Masuk
                </n-button>
            </div>
        </n-form>
        <n-form
            v-else-if="tab === 'signup'"
            ref="signUpRef"
            class="w-72 sm:w-80 lg:w-96 overflow-y-auto max-h-96"
            size="large"
            :model="signUpForm"
            :rules="signUpRules"
            @submit.prevent="signUp">
            <n-h1 class="text-center">Daftar</n-h1>
            <n-form-item
                path="name"
                label="Nama">
                <n-input
                    v-model:value="signUpForm.name"
                    placeholder="Nama Lengkap Anda" />
            </n-form-item>
            <n-element
                v-if="signUpForm.errors.name"
                class="text-[var(--error-color)] mb-6">
                {{ signUpForm.errors.name }}
            </n-element>
            <n-form-item
                path="age"
                label="Usia">
                <n-input-number
                    v-model:value="signUpForm.age"
                    :min="0"
                    placeholder="Usia Anda"
                    style="display: flex; flex: 1">
                    <template #suffix> Tahun</template>
                </n-input-number>
            </n-form-item>
            <n-element
                v-if="signUpForm.errors.age"
                class="text-[var(--error-color)] mb-6">
                {{ signUpForm.errors.age }}
            </n-element>
            <n-form-item
                path="gender"
                label="Jenis Kelamin">
                <n-select
                    v-model:value="signUpForm.gender"
                    filterable
                    :options="genderOptions"
                    placeholder="Jenis Kelamin Anda" />
            </n-form-item>
            <n-element
                v-if="signUpForm.errors.gender"
                class="text-[var(--error-color)] mb-6">
                {{ signUpForm.errors.gender }}
            </n-element>
            <n-form-item
                path="occupation"
                label="Pekerjaan">
                <n-input
                    v-model:value="signUpForm.occupation"
                    placeholder="Pekerjaan Anda" />
            </n-form-item>
            <n-element
                v-if="signUpForm.errors.occupation"
                class="text-[var(--error-color)] mb-6">
                {{ signUpForm.errors.occupation }}
            </n-element>
            <n-form-item
                path="address"
                label="Alamat">
                <n-input
                    v-model:value="signUpForm.address"
                    placeholder="Alamat Anda" />
            </n-form-item>
            <n-element
                v-if="signUpForm.errors.address"
                class="text-[var(--error-color)] mb-6">
                {{ signUpForm.errors.address }}
            </n-element>
            <n-form-item
                path="contact"
                label="Kontak">
                <n-input
                    v-model:value="signUpForm.contact"
                    placeholder="Kontak Anda" />
            </n-form-item>
            <n-element
                v-if="signUpForm.errors.contact"
                class="text-[var(--error-color)] mb-6">
                {{ signUpForm.errors.contact }}
            </n-element>
            <n-form-item
                path="email"
                label="Email">
                <n-auto-complete
                    v-model:value="signUpForm.email"
                    :options="emailOptions(signUpForm)"
                    placeholder="budi@contoh.com"
                    type="text">
                </n-auto-complete>
            </n-form-item>
            <n-element
                v-if="signUpForm.errors.email"
                class="text-[var(--error-color)] mb-6">
                {{ signUpForm.errors.email }}
            </n-element>
            <n-form-item
                path="password"
                label="Password">
                <n-input
                    v-model:value="signUpForm.password"
                    placeholder="Password"
                    show-password-on="click"
                    type="password" />
            </n-form-item>
            <n-form-item
                first
                path="reenteredPassword"
                label="Ulangi Password">
                <n-input
                    v-model:value="signUpForm.reenteredPassword"
                    placeholder="Ulangi Password"
                    show-password-on="click"
                    type="password" />
            </n-form-item>
            <div>
                <n-button
                    :disabled="signUpForm.processing"
                    :loading="signUpForm.processing"
                    attr-type="submit"
                    size="large"
                    block
                    type="success"
                    >Daftar
                </n-button>
            </div>
        </n-form>
    </Transition>
</template>
<style scoped>
.slide-left-enter-active,
.slide-left-leave-active,
.slide-right-enter-active,
.slide-right-leave-active {
    transition: all 0.1s ease-out;
}

.slide-left-enter-from {
    opacity: 0;
    transform: translateX(30px);
}

.slide-left-leave-to {
    opacity: 0;
    transform: translateX(-30px);
}

.slide-right-enter-from {
    opacity: 0;
    transform: translateX(-30px);
}

.slide-right-leave-to {
    opacity: 0;
    transform: translateX(30px);
}
</style>
