<script setup lang="ts">
import { watch } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { useMessage } from 'naive-ui';
import { useFlash } from '@/scripts/composables/flash';

const message = useMessage();

watch(
    usePage().props,
    () => {
        const { alert } = useFlash();
        if (alert.content) {
            switch (alert.type) {
            case 'error':
                message.error(alert.content, {
                    closable: true,
                });
                break;
            case 'warning':
                message.warning(alert.content, {
                    closable: true,
                });
                break;
            case 'success':
                message.success(alert.content, {
                    closable: true,
                });
                break;
            default:
                message.info(alert.content, {
                    closable: true,
                });
                break;
            }
        }
    },
    { deep: true }
);
</script>
<template>
    <slot />
</template>
