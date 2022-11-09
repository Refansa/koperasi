<script setup lang="ts">
import { CSSProperties } from 'vue';

const backgroundStyle: CSSProperties = {
    maxWidth: '100vw',
    minHeight: '100vh',

    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',

    backgroundSize: 'cover',
    backgroundImage: "url('/images/Sprinkle.svg')",
};
</script>
<template>
    <div :style="backgroundStyle">
        <slot />
    </div>
</template>
