<script setup lang="ts">
import { Head, Link } from '@inertiajs/inertia-vue3';
import Navbar from '@/views/components/navbar/navbar-home.vue';
import NormalLayout from '@/views/layouts/normal-layout.vue';
import Logo from '@/views/components/logo.vue';
import { GlobalTheme, NElement, NIcon, NDivider } from 'naive-ui';
import { AccessAlarmFilled, AttachMoneyFilled } from '@vicons/material';
import { FlowerOutline } from '@vicons/ionicons5';
import { Ref, inject } from 'vue';
// @ts-ignore
import AOS from 'aos';
import 'aos/dist/aos.css';

AOS.init({
    once: true,
});

const theme: Ref<GlobalTheme> | undefined = inject('theme');
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
            class="lg:flex lg:h-[34rem] p-5 mt-5"
            :style="`background-image: url('/images/${
                theme?.name == 'dark' ? 'hero-bg-dark' : 'hero-bg-light'
            }.svg');
            background-position: center;
            background-size: cover;`">
            <div class="w-full lg:w-8/12 p-5 lg:p-10">
                <div class="mt-5 lg:mt-20 p-5">
                    <h1
                        class="font-bold text-3xl md:text-4xl lg:text-5xl xl:text-6xl">
                        Solusi Terbaik
                    </h1>
                    <n-element
                        class="font-bold text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl text-[var(--success-color)]">
                        Untuk Mengelola Keuanganmu
                    </n-element>
                    <p class="mt-8 xl:text-lg">
                        Koperasi Maju Bersama adalah salah satu koperasi yang
                        mensejahterakan anggotanya dengan menyediakan simpanan
                        dan pinjaman dalam jangka waktu panjang serta bunga yang
                        rendah.
                    </p>
                </div>
            </div>
            <div
                class="w-full lg:w-4/12 p-5 lg:p-0 flex items-center justify-center">
                <img
                    alt=""
                    :src="
                        theme?.name == 'dark'
                            ? '/images/hero-dark.svg'
                            : '/images/hero-light.svg'
                    " />
            </div>
        </div>
        <div
            class="w-full pt-24"
            :style="
                theme?.name == 'dark'
                    ? 'background: #63E2B7'
                    : 'background: #18A058'
            ">
            <section
                id="feature"
                class="py-10 lg:p-20 lg:px-32"
                :style="
                    theme?.name == 'dark'
                        ? 'background: #18181c'
                        : 'background: white'
                ">
                <h3 class="text-3xl text-center mt-10 mb-3">Fitur Kami</h3>
                <n-divider />
                <div class="grid lg:grid-cols-3 gap-4 mt-10 mb-20 text-center">
                    <Link href="#feature-time">
                        <div
                            class="flex-col flex justify-center items-center p-5">
                            <n-icon size="64">
                                <access-alarm-filled />
                            </n-icon>
                            <span class="text-xl lg:text-2xl">Pinjaman</span>
                            <span class="text-xl lg:text-2xl"
                                >Jangka Panjang</span
                            >
                        </div>
                    </Link>
                    <Link href="#feature-interest">
                        <div
                            class="flex-col flex justify-center items-center p-5">
                            <n-icon size="64">
                                <flower-outline />
                            </n-icon>
                            <span class="text-xl lg:text-2xl">Bunga</span>
                            <span class="text-xl lg:text-2xl">Rendah</span>
                        </div>
                    </Link>
                    <Link href="#feature-transaction">
                        <div
                            class="flex-col flex justify-center items-center p-5">
                            <n-icon size="64">
                                <attach-money-filled />
                            </n-icon>
                            <span class="text-xl lg:text-2xl">Simpan</span>
                            <span class="text-xl lg:text-2xl">Online</span>
                        </div>
                    </Link>
                </div>
                <n-divider id="feature-time" />
                <div
                    data-aos="fade-up"
                    class="lg:flex lg:p-10 my-10">
                    <div
                        class="w-full lg:w-8/12 p-5 lg:p-10 text-center lg:text-left">
                        <div class="p-5">
                            <h1
                                class="font-bold text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl">
                                Pilih Jangka Waktu Pinjaman Hingga 2 Tahun!
                            </h1>
                            <p class="mt-8 xl:text-lg">
                                Salah satu kelebihan dari Koperasi Maju Bersama
                                adalah peminjaman jangka panjang yang tersedia
                                bagi anggotanya. Hal ini memungkinkan anggota
                                koperasi untuk memperoleh modal yang cukup besar
                                untuk keperluan usaha atau kebutuhan lainnya.
                            </p>
                        </div>
                    </div>
                    <div
                        class="w-full lg:w-4/12 p-5 lg:p-0 flex items-center justify-center">
                        <img
                            alt=""
                            :src="
                                theme?.name == 'dark'
                                    ? '/images/feature-time-dark.svg'
                                    : '/images/feature-time-light.svg'
                            " />
                    </div>
                </div>
                <n-divider id="feature-interest" />
                <div
                    data-aos="fade-up"
                    class="lg:flex p-10 my-10">
                    <div
                        class="w-full lg:w-4/12 p-5 lg:p-0 flex items-center justify-center">
                        <img
                            alt=""
                            :src="
                                theme?.name == 'dark'
                                    ? '/images/feature-interest-dark.svg'
                                    : '/images/feature-interest-light.svg'
                            " />
                    </div>
                    <div
                        class="w-full lg:w-8/12 p-5 lg:p-10 text-center lg:text-left">
                        <div class="p-5">
                            <h1
                                class="font-bold text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl">
                                Bunga Pinjaman Maksimal 2%!
                            </h1>
                            <p class="mt-8 xl:text-lg">
                                Koperasi Maju Bersama juga menawarkan bunga
                                rendah yang membuat anggota koperasi tidak perlu
                                khawatir akan terbebani dengan biaya bunga yang
                                tinggi. Dengan begitu, anggota koperasi dapat
                                meminjam uang dengan biaya yang lebih terjangkau
                                dan dapat memperoleh keuntungan yang lebih besar
                                dari kegiatan usahanya.
                            </p>
                        </div>
                    </div>
                </div>
                <n-divider id="feature-transaction" />
                <div
                    data-aos="fade-up"
                    class="lg:flex p-10 my-10">
                    <div
                        class="w-full lg:w-8/12 p-5 lg:p-10 text-center lg:text-left">
                        <div class="p-5">
                            <h1
                                class="font-bold text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl">
                                Akses Mudah, Transaksi Online!
                            </h1>
                            <p class="mt-8 xl:text-lg">
                                Koperasi Maju Bersama juga memudahkan anggotanya
                                dengan layanan transaksi online yang tersedia.
                                Hal ini memungkinkan anggota koperasi untuk
                                melakukan transaksi dengan mudah dan cepat tanpa
                                harus mengunjungi kantor koperasi secara
                                langsung. Dengan adanya layanan transaksi
                                online, anggota koperasi dapat menghemat waktu
                                dan biaya dalam melakukan transaksi keuangan.
                            </p>
                        </div>
                    </div>
                    <div
                        class="w-full lg:w-4/12 p-5 lg:p-0 flex items-center justify-center">
                        <img
                            alt=""
                            :src="
                                theme?.name == 'dark'
                                    ? '/images/feature-transaction-dark.svg'
                                    : '/images/feature-transaction-light.svg'
                            " />
                    </div>
                </div>
            </section>
            <section
                id="about"
                class="p-10 lg:px-32"
                :style="
                    theme?.name == 'dark'
                        ? 'background: #18181c'
                        : 'background: white'
                ">
                <h3 class="text-3xl text-center mb-3">Tentang Kami</h3>
                <n-divider />
                <div
                    data-aos="fade-up"
                    class="lg:flex p-10">
                    <div
                        class="w-full lg:w-4/12 lg:p-0 flex items-center justify-center">
                        <logo
                            :width="200"
                            :height="200" />
                    </div>
                    <div class="w-full lg:w-8/12 p-5 lg:p-10">
                        <div class="lg:p-5">
                            <h1
                                class="font-bold text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl">
                                Koperasi Maju Bersama
                            </h1>
                            <p class="mt-8 xl:text-lg">
                                Koperasi Maju Bersama adalah sebuah koperasi
                                yang didirikan dengan tujuan memberikan
                                kemudahan akses bagi anggotanya dalam melakukan
                                transaksi keuangan. Dengan peminjaman jangka
                                panjang, bunga rendah, dan layanan transaksi
                                online, Koperasi Maju Bersama memberikan solusi
                                yang tepat bagi anggotanya dalam memperoleh
                                modal dan mengembangkan usahanya.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <section
                id="contact"
                class="p-10 lg:px-32"
                :style="
                    theme?.name == 'dark'
                        ? 'background: #18181c'
                        : 'background: white'
                ">
                <h3 class="text-3xl text-center mb-3">Kontak Kami</h3>
                <n-divider />
                <div
                    data-aos="fade-up"
                    class="px-10 py-5">
                    <p class="text-center xl:text-lg">
                        Kami senang mendengar dari Anda dan siap membantu
                        menjawab segala pertanyaan yang Anda miliki terkait
                        dengan layanan dan produk yang kami tawarkan. Silakan
                        hubungi kami melalui salah satu kontak di bawah, dan tim
                        kami akan merespon secepat mungkin. Terima kasih!
                    </p>
                    <div class="hidden lg:block mapouter mt-10">
                        <div class="gmap_canvas">
                            <iframe
                                width="1080"
                                height="500"
                                id="gmap_canvas"
                                src="https://maps.google.com/maps?q=Cileungsi,%20Bogor&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                frameborder="0"
                                scrolling="no"
                                marginheight="0"
                                marginwidth="0"></iframe
                            ><br />
                            ><a href="https://www.embedgooglemap.net"
                                >embedgooglemap.net</a
                            >
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-3 gap-4 my-10">
                        <div>
                            <p class="text-lg font-bold">Email:</p>
                            <p>admin@koperasi.com</p>
                        </div>
                        <div>
                            <p class="text-lg font-bold">Telepon:</p>
                            <p>+62 812 8543 3284</p>
                        </div>
                        <div>
                            <p class="text-lg font-bold">Alamat Kantor:</p>
                            <p>Jl. Kesuksesan, Cileungsi, Bogor</p>
                        </div>
                    </div>
                </div>
            </section>
            <section
                id="footer"
                class="h-12 text-center flex justify-center items-center">
                <span
                    :class="{
                        'text-lg': true,
                        'text-[#111]': theme?.name == 'dark',
                        'text-[#eee]': theme?.name == 'light',
                    }"
                    >Created With Care By Refansa & Fina</span
                >
            </section>
        </div>
    </normal-layout>
</template>
<style scoped>
.gmap_canvas {
    overflow: hidden;
    background: none !important;
    height: 500px;
    width: 1080px;
}

.mapouter {
    position: relative;
    text-align: right;
    height: 500px;
    width: 1080px;
}
</style>
