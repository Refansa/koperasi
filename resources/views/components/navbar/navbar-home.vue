<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import Logo from '@/views/components/logo.vue';
import KoperasiLogo from '@/views/components/koperasi-logo.vue';
import AvatarDropdown from '@/views/components/navbar/navbar-avatar.vue';
import { NTag, NSpace } from 'naive-ui';
import route from 'ziggy-js';
</script>
<template>
    <div class="py-3 px-5">
        <n-space
            justify="space-between"
            align="center"
            :wrap="false">
            <div class="flex items-center gap-4">
                <Link :href="route('home')">
                    <logo class="flex sm:hidden" />
                    <koperasi-logo class="hidden sm:flex" />
                </Link>
            </div>
            <n-space
                justify="end"
                align="center"
                :wrap="false">
                <div class="hidden md:flex gap-5 mr-10 font-bold">
                    <Link href="#feature">Fitur Kami</Link>
                    <Link href="#about">Tentang Kami</Link>
                    <Link href="#contact">Kontak Kami</Link>
                </div>
                <avatar-dropdown />
            </n-space>
        </n-space>
    </div>
</template>
