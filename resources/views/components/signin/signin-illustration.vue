<script setup lang="ts">
import { Ref, inject, CSSProperties } from 'vue';
import { GlobalTheme } from 'naive-ui';

const theme: Ref<GlobalTheme> | undefined = inject('theme');

const themeStyle = {
    color:
        theme?.value.name === 'dark'
            ? 'rgb(99, 226, 183, var(--tw-bg-opacity))'
            : 'rgb(24, 160, 88, var(--tw-bg-opacity))',
};

const illustrationStyle: CSSProperties = {
    '--tw-bg-opacity': theme?.value.name === 'dark' ? '0.5' : '0.9',
    backgroundColor: themeStyle.color,
};

const illustrationStyle2: CSSProperties = {
    '--tw-bg-opacity': theme?.value.name === 'dark' ? '0.5' : '1',
    backgroundColor: themeStyle.color,
    borderRadius: '9999px',
    overflow: 'hidden',
    width: '400px',
    height: '400px',
};
</script>
<template>
    <div
        :style="illustrationStyle"
        class="p-10 grid place-items-center">
        <div
            :style="illustrationStyle2"
            class="flex justify-center items-center">
            <img
                width="400"
                height="400"
                class="p-8"
                src="/images/Daftar.svg"
                alt="Daftar!" />
        </div>
    </div>
</template>
