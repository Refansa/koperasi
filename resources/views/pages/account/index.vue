<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import Navbar from '@/views/components/navbar/navbar.vue';
import UserLayout from '@/views/layouts/user-layout.vue';
import UserMenu from '@/views/components/user/user-menu.vue';
import {
    NText,
    NCard,
    NSpace,
    NGrid,
    NGridItem,
    NAvatar,
    NTag,
    NButton,
} from 'naive-ui';
import { useAuth } from '@/scripts/composables/auth';
import { SavingProperties } from '@/scripts/composables/model';
import route from 'ziggy-js';

const props = defineProps<{
    saving: SavingProperties;
}>();

const auth = useAuth();

const active = 'dashboard';
</script>
<template layout="default">
    <Head>
        <title>Dashboard</title>
    </Head>
    <user-layout>
        <template #header>
            <navbar />
        </template>
        <template #sidebar>
            <user-menu :active="active"></user-menu>
        </template>
        <template #default>
            <div class="flex gap-8">
                <div class="w-1/3">
                    <n-card>
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
                                    auth.user?.picture ??
                                    '/images/default-profile.jpg'
                                " />
                            <div class="flex flex-col items-center">
                                <h3 class="font-bold text-xl">
                                    {{ auth.user.name }}
                                </h3>
                            </div>
                        </n-space>
                        <n-space
                            vertical
                            align="center"
                            justify="center">
                            <n-text depth="3">{{ auth.user.email }}</n-text>
                            <n-tag :bordered="false">{{
                                auth.user.role
                            }}</n-tag>
                        </n-space>
                        <n-space vertical>
                            <div class="flex flex-col">
                                <n-text>Usia:</n-text>
                                <n-text>{{ auth.user.age }} Tahun</n-text>
                            </div>
                            <div class="flex flex-col">
                                <n-text>Jenis Kelamin:</n-text>
                                <n-text>{{ auth.user.gender }}</n-text>
                            </div>
                            <div class="flex flex-col">
                                <n-text>Alamat:</n-text>
                                <n-text>{{ auth.user.address }}</n-text>
                            </div>
                            <div class="flex flex-col">
                                <n-text>Kontak:</n-text>
                                <n-text>{{ auth.user.contact }}</n-text>
                            </div>
                        </n-space>
                        <template #action>
                            <Link :href="route('account.settings.index')">
                                <n-button
                                    type="primary"
                                    block
                                    >Pengaturan</n-button
                                >
                            </Link>
                        </template>
                    </n-card>
                </div>
                <div class="flex-1">
                    <n-grid
                        :cols="1"
                        :y-gap="20">
                        <n-grid-item>
                            <n-card title="Total Tabungan">
                                <n-text class="text-2xl">
                                    Rp.
                                    {{
                                        (
                                            (saving?.basic_amount ?? 0) +
                                            (saving?.mandatory_amount ?? 0) +
                                            (saving?.voluntary_amount ?? 0)
                                        ).toLocaleString('id-ID')
                                    }}
                                </n-text>
                            </n-card>
                        </n-grid-item>
                        <n-grid-item>
                            <n-card title="Tabungan Pokok">
                                <n-text class="text-2xl">
                                    Rp.
                                    {{
                                        (
                                            saving.basic_amount ?? 0
                                        ).toLocaleString('id-ID')
                                    }}
                                </n-text>
                            </n-card>
                        </n-grid-item>
                        <n-grid-item>
                            <n-card title="Tabungan Wajib">
                                <n-text class="text-2xl">
                                    Rp.
                                    {{
                                        (
                                            saving.mandatory_amount ?? 0
                                        ).toLocaleString('id-ID')
                                    }}
                                </n-text>
                            </n-card>
                        </n-grid-item>
                        <n-grid-item>
                            <n-card title="Tabungan Sukarela">
                                <n-text class="text-2xl">
                                    Rp.
                                    {{
                                        (
                                            saving.voluntary_amount ?? 0
                                        ).toLocaleString('id-ID')
                                    }}
                                </n-text>
                            </n-card>
                        </n-grid-item>
                    </n-grid>
                </div>
            </div>
        </template>
    </user-layout>
</template>
