<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';

import { ref } from 'vue';

import Logo from '@/views/components/logo.vue';
import KoperasiLogo from '@/views/components/koperasi-logo.vue';
import CartButton from '@/views/components/navbar/cart-button.vue';
import AvatarDropdown from '@/views/components/navbar/avatar-dropdown.vue';

import { Search } from '@vicons/ionicons5';

import {
    NIcon,
    NInput,
    NSpace,
} from 'naive-ui';

const search = ref(null);

// TODO: Create a function to perform search query.
function performSearch(e: KeyboardEvent) {
    console.log(e);
    console.log(search.value);
}

</script>
<template>
    <div class="py-3 px-5">
        <n-space justify="space-between" align="center" :wrap="false">
            <Link href="/">
            <logo class="flex sm:hidden" />
            <koperasi-logo class="hidden sm:flex" />
            </Link>
            <n-input style="width: 100%" @keydown.enter="performSearch" v-model:value="search" placeholder="Cari">
                <template #suffix>
                    <n-icon :component="Search" />
                </template>
            </n-input>
            <n-space justify="end" align="center" :wrap="false">
                <cart-button />
                <avatar-dropdown />
            </n-space>
        </n-space>
    </div>
</template>
