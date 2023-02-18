<script setup lang="ts">
import { Head } from '@inertiajs/inertia-vue3';
import Navbar from '@/views/components/navbar/navbar.vue';
import NormalLayout from '@/views/layouts/normal-layout.vue';
import { NElement } from 'naive-ui';
</script>
<template layout="default">
    <Head>
        <title>Halaman Utama</title>
    </Head>
    <normal-layout>
        <template #header>
            <navbar />
        </template>
        <div
            class="flex h-[33rem]"
            style="
                /* background-image: url('/images/Sprinkle.svg'); */
                background-size: cover;
                background-position: center;
            ">
            <div class="w-8/12 p-10">
                <div class="mt-20 p-5">
                    <h1
                        class="font-bold text-3xl md:text-4xl lg:text-5xl xl:text-6xl">
                        Solusi Terbaik
                    </h1>
                    <n-element
                        class="font-bold text-2xl md:text-3xl lg:text-4xl xl:text-5xl text-[var(--success-color)]">
                        Untuk Mengelola Keuanganmu
                    </n-element>
                    <p class="mt-8 xl:text-lg">
                        Lorem ipsum dolor sit, amet consectetur adipisicing
                        elit. Recusandae sequi, ipsam aspernatur omnis, error
                        nobis similique quis saepe eius modi odio praesentium
                        fuga, cum explicabo esse adipisci dolor! Labore,
                        expedita.
                    </p>
                </div>
            </div>
            <div class="w-4/12 flex items-center justify-center">
                <img alt="Gambar Disini" />
            </div>
        </div>
    </normal-layout>
</template>
