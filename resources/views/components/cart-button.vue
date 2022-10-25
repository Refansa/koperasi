<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';

import { NBadge, NButton } from "naive-ui";
import { Cart } from "@vicons/ionicons5";

defineProps<{ value?: number | string }>();

</script>
<template>
    <n-badge :value="value" :max="9">
        <Link href="/cart">
        <n-button size="large" secondary circle>
            <template #icon>
                <cart />
            </template>
        </n-button>
        </Link>
    </n-badge>
</template>
