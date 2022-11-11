<script setup lang="ts">
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { NSpace, NButton, useDialog, NForm } from 'naive-ui';

const props = defineProps<{
    editHref: string;
    deleteHref: string;
}>();

const dialog = useDialog();

const confirmation = () => {
    dialog.warning({
        title: 'Konfirmasi',
        content: 'Apa anda yakin ingin menghapus data ini?',
        positiveText: 'Hapus',
        negativeText: 'Batal',
        onPositiveClick: () => {
            Inertia.delete(props.deleteHref);
        },
    });
};
</script>
<template>
    <n-space
        justify="center"
        align="center">
        <Link :href="editHref">
            <n-button type="info">Edit</n-button>
        </Link>
        <n-form @submit.prevent="confirmation">
            <n-button
                type="error"
                attr-type="submit">
                Hapus
            </n-button>
        </n-form>
    </n-space>
</template>
