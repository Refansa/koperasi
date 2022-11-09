<script setup lang="ts">
import { Link } from '@inertiajs/inertia-vue3';
import { NSpace, NButton } from 'naive-ui';

defineProps<{
    editHref: string;
    deleteHref: string;
}>();
</script>
<template>
    <n-space
        justify="center"
        align="center">
        <Link :href="editHref">
            <n-button type="info">Edit</n-button>
        </Link>
        <Link
            as="button"
            :href="deleteHref"
            method="delete"
            preserve-state>
            <n-button type="error">Hapus</n-button>
        </Link>
    </n-space>
</template>
