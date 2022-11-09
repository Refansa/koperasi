<script setup lang="ts">
import { Ref, inject } from 'vue';
import { GlobalTheme } from 'naive-ui';

const theme: Ref<GlobalTheme> | undefined = inject('theme');

const stroke = () => (theme?.value.name === 'dark' ? '#63E2B7' : '#18A058');
</script>
<template>
    <div class="flex gap-2 justify-center items-center">
        <svg
            width="30"
            height="30"
            viewBox="0 0 30 30"
            fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <circle
                cx="15"
                cy="15"
                r="14"
                :stroke="stroke()"
                stroke-width="2" />
            <path
                d="M5.23047 9.42016L14.1177 7.53113C14.3771 7.47599 14.6478 7.52616 14.8702 7.67061L18.9197 10.3004C19.1421 10.4448 19.4128 10.495 19.6722 10.4399L21.7125 10.0062C22.2527 9.89136 22.7837 10.2362 22.8985 10.7764L23.2104 12.2437C23.3252 12.7839 22.9804 13.3149 22.4401 13.4297L18.9327 14.1752C18.6733 14.2304 18.4026 14.1802 18.1802 14.0358L14.1307 11.406C13.9083 11.2616 13.6376 11.2114 13.3782 11.2665L11.827 11.5962"
                :stroke="stroke()"
                stroke-width="2"
                stroke-linecap="round" />
            <path
                d="M24.7695 19.5796L15.8823 21.4687C15.6228 21.5238 15.3521 21.4736 15.1297 21.3292L11.0803 18.6994C10.8578 18.555 10.5871 18.5048 10.3277 18.56L8.28748 18.9936C7.74728 19.1084 7.21627 18.7636 7.10144 18.2234L6.78957 16.7562C6.67475 16.2159 7.01959 15.6849 7.55981 15.5701L11.0672 14.8246C11.3267 14.7694 11.5974 14.8196 11.8198 14.964L15.8692 17.5938C16.0917 17.7382 16.3624 17.7884 16.6218 17.7333L18.173 17.4036"
                :stroke="stroke()"
                stroke-width="2"
                stroke-linecap="round" />
        </svg>
    </div>
</template>
