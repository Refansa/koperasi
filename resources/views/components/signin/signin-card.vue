<script setup lang="ts">
import { CSSProperties } from 'vue';

import { NElement } from 'naive-ui';

const cardStyle: CSSProperties = {
    display: 'flex',
    minHeight: '550px',
    border: '1px solid var(--divider-color)',
    backgroundColor: 'var(--card-color)',
    borderRadius: '1rem',
    overflow: 'hidden',
    boxShadow: 'var(--box-shadow-1)',
}

</script>
<template>
    <div>
        <n-element :style="cardStyle">
            <slot />
        </n-element>
    </div>
</template>
