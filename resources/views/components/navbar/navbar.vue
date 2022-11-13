<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import Logo from '@/views/components/logo.vue';
import KoperasiLogo from '@/views/components/koperasi-logo.vue';
import CartButton from '@/views/components/navbar/navbar-cart.vue';
import AvatarDropdown from '@/views/components/navbar/navbar-avatar.vue';
import { Search } from '@vicons/ionicons5';
import { NTag, NIcon, NInput, NSpace } from 'naive-ui';
import route from 'ziggy-js';

defineProps<{ type?: 'admin' }>();
const search = ref(null);

// TODO: Create a function to perform search query.
function performSearch(e: KeyboardEvent) {
    console.log(e);
    console.log(search.value);
}
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
                <n-tag
                    v-if="type === 'admin'"
                    :bordered="false"
                    >Admin</n-tag
                >
            </div>
            <n-input
                v-if="type !== 'admin'"
                v-model:value="search"
                style="width: 100%"
                placeholder="Cari"
                @keydown.enter="performSearch">
                <template #suffix>
                    <n-icon :component="Search" />
                </template>
            </n-input>
            <n-space
                justify="end"
                align="center"
                :wrap="false">
                <cart-button v-if="type !== 'admin'" />
                <avatar-dropdown />
            </n-space>
        </n-space>
    </div>
</template>
