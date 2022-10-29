<script setup lang="ts">
import { useForm } from '@inertiajs/inertia-vue3';

import {
    ref,
    Transition,
} from 'vue';

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
} from 'naive-ui';

defineProps<{ tab?: string }>();

const signInRef = ref<FormInst | null>(null);
const signUpRef = ref<FormInst | null>(null);

interface SignInType {
    email?: string,
    password?: string,
    rememberMe?: boolean,
}

interface SignUpType {
    email?: string,
    password?: string,
    reenteredPassword?: string,
}

const signInForm = useForm<SignInType>({
    email: '',
    password: '',
    rememberMe: false,
});

const signUpForm = useForm<SignUpType>({
    email: '',
    password: '',
    reenteredPassword: '',
});

function validatePasswordStartWith(
    rule: FormItemRule,
    value: string
): boolean {
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
        }
    ],
}

const signUpRules: FormRules = {
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
        }
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
            trigger: 'input'
        },
        {
            validator: validatePasswordSame,
            message: 'Password tidak sama dengan yang diulangi!',
            trigger: ['blur', 'password-input']
        }
    ],
}

const emailOptions = (model: any) => {
    return [
        ['Google', '@gmail.com'],
        ['Yahoo', '@yahoo.com'],
        ['Outlook', '@outlook.com'],
    ].map(emailInfo => {
        return {
            type: 'group',
            label: emailInfo[0],
            key: emailInfo[0],
            children: [model.email?.split('@')[0] + emailInfo[1]],
        }
    });
}

const signIn = (e: Event) => {
    signInRef.value?.validate((errors) => {
        if (!errors) {
            signInForm.post('/signin');
        }
    })
}

const signUp = (e: Event) => {
    signUpRef.value?.validate((errors) => {
        if (!errors) {
            signUpForm.post('/signup');
        }
    })
}

</script>
<template>
    <Transition :name="tab === 'signin' ? 'slide-right' : 'slide-left'" mode="out-in">
        <n-form @submit.prevent="signIn" class="w-72 sm:w-80 lg:w-96" size="large" ref="signInRef" :model="signInForm"
            :rules="signInRules" v-if="tab === 'signin'">
            <n-h1 class="text-center">Masuk</n-h1>
            <n-form-item path="email" label="Email">
                <n-auto-complete :options="emailOptions(signInForm)" placeholder="budi@contoh.com"
                    v-model:value="signInForm.email" type="text">
                </n-auto-complete>
            </n-form-item>
            <n-form-item path="password" label="Password">
                <n-input placeholder="Password" show-password-on="click" v-model:value="signInForm.password"
                    type="password" />
            </n-form-item>
            <div class="flex flex-col gap-4">
                <n-text v-if="signInForm.errors.email" type="error">
                    {{ signInForm.errors.email }}
                </n-text>
                <n-checkbox size="large" v-model:checked="signInForm.rememberMe">Remember Me</n-checkbox>
            </div>
            <div class="mt-8">
                <n-button :disabled="signInForm.processing" attr-type="submit" size="large" block type="success">Masuk
                </n-button>
            </div>
        </n-form>
        <n-form @submit.prevent="signUp" class="w-72 sm:w-80 lg:w-96" size="large" ref="signUpRef" :model="signUpForm"
            :rules="signUpRules" v-else-if="tab === 'signup'">
            <n-h1 class="text-center">Daftar</n-h1>
            <n-form-item path="email" label="Email">
                <n-auto-complete :options="emailOptions(signUpForm)" placeholder="budi@contoh.com"
                    v-model:value="signUpForm.email" type="text">
                </n-auto-complete>
            </n-form-item>
            <n-form-item path="password" label="Password">
                <n-input placeholder="Password" show-password-on="click" v-model:value="signUpForm.password"
                    type="password" />
            </n-form-item>
            <n-form-item first path="reenteredPassword" label="Ulangi Password">
                <n-input placeholder="Ulangi Password" show-password-on="click"
                    v-model:value="signUpForm.reenteredPassword" type="password" />
            </n-form-item>
            <div>
                <n-button :disabled="signUpForm.processing" attr-type="submit" size="large" block type="success">Daftar
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
