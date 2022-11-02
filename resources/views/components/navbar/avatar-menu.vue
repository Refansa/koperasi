<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';

import { inject } from 'vue';

import { useAuth } from '@/scripts/composables/auth';
import { setTheme } from '@/scripts/composables/theme';

import {
    Moon,
    Sunny,
    Person,
    LogOut,
} from '@vicons/ionicons5';
import { AdminPanelSettingsFilled } from '@vicons/material';

import {
    NTag,
    NIcon,
    NCard,
    NSpace,
    NButton,
    NAvatar,
    NDivider,
} from 'naive-ui';

const theme: any = inject('theme');

const auth = useAuth();

function toggleTheme() {
    setTheme(theme);
}

</script>
<template>
    <n-card content-style="min-width: 20rem;">
        <n-space vertical align="center" justify="center">
            <n-avatar bordered :size="72" object-fit="cover" round src="/images/avatar-test.gif" />
            <div class="flex flex-col items-center">
                <h3 class="font-bold text-xl">{{ auth.user.name }}</h3>
                <h4 class="font-bold mb-2">{{ auth.user.email }}</h4>
                <n-tag :bordered="false">{{ auth.user.role }}</n-tag>
            </div>
        </n-space>
        <n-divider />
        <n-space vertical>
            <Link v-if="auth.user.role === 'admin'" href="/admin">
            <n-button style="justify-content: left;" size="large" strong block quaternary>
                <template #icon>
                    <n-icon>
                        <admin-panel-settings-filled />
                    </n-icon>
                </template>
                Admin
            </n-button>
            </Link>
            <Link v-else href="/account">
            <n-button style="justify-content: left;" size="large" strong block quaternary>
                <template #icon>
                    <n-icon>
                        <person />
                    </n-icon>
                </template>
                Akun
            </n-button>
            </Link>
            <n-button @click="toggleTheme" style="justify-content: left;" size="large" strong block quaternary>
                <template #icon>
                    <n-icon>
                        <sunny v-if="theme.name === 'light'" />
                        <moon v-else />
                    </n-icon>
                </template>
                Tema
            </n-button>
        </n-space>
        <n-divider />
        <n-space vertical>
            <Link as="button" class="w-full" href="/signout" method="post">
            <n-button style="justify-content: left;" size="large" strong block quaternary>
                <template #icon>
                    <n-icon>
                        <log-out />
                    </n-icon>
                </template>
                Keluar
            </n-button>
            </Link>
        </n-space>
    </n-card>
</template>
