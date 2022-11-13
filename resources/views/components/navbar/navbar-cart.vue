<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';

import { Cart } from '@vicons/ionicons5';

import { NBadge, NButton } from 'naive-ui';

import route from 'ziggy-js';

interface CartButtonProps {
    value?: number | string;
}

defineProps<CartButtonProps>();
</script>
<template>
    <n-badge
        :value="value"
        :max="9">
        <Link :href="route('stub')">
            <n-button
                size="large"
                secondary
                circle>
                <template #icon>
                    <cart />
                </template>
            </n-button>
        </Link>
    </n-badge>
</template>
