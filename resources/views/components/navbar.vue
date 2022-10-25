<script setup lang="ts">
import { NSpace } from 'naive-ui';
import { Link } from '@inertiajs/inertia-vue3';
import CartButton from '@/views/components/cart-button.vue';
import ThemeSwitch from '@/views/components/theme-switch.vue';
import AvatarDropdown from '@/views/components/avatar-dropdown.vue';

</script>
<template>
    <div class="py-3 px-5">
        <n-space justify="space-between" align="center">
            <n-space />
            <n-space justify="end" align="center">
                <theme-switch />
                <cart-button />
                <avatar-dropdown />
            </n-space>
        </n-space>
    </div>
</template>
