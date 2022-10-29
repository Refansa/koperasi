<script setup lang="ts">
import { onMounted } from 'vue';

import { useAlert } from '@/scripts/composables/alert';

onMounted(() => {
    useAlert();
});
</script>
<template>
    <slot />
</template>
