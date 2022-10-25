<script setup lang="ts">
import {
    NLayout,
    NLayoutContent,
    NCard,
    NTabs,
    NTabPane,
    NForm,
    NFormItemRow,
    NInput,
    NButton,
    NSpace,
} from "naive-ui";

</script>
<template layout="default">
    <n-layout>
        <n-layout-content>
            <n-space justify="center" align="center" style="height: 100vh; width: 100vw; background-image: url('/Sprinkle.svg'); background-position: center; background-size: cover;">
                <n-card size="huge" style="max-width: 80rem">
                    <n-tabs class="card-tabs" default-value="signin" size="large" animated style="margin: 0 -4px"
                        pane-style="padding-left: 4px; padding-right: 4px; box-sizing: border-box;">
                        <n-tab-pane name="signin" tab="Sign in">
                            <n-form>
                                <n-form-item-row label="Username">
                                    <n-input />
                                </n-form-item-row>
                                <n-form-item-row label="Password">
                                    <n-input />
                                </n-form-item-row>
                            </n-form>
                            <n-button type="primary" block strong>
                                Sign In
                            </n-button>
                        </n-tab-pane>
                        <n-tab-pane name="signup" tab="Sign up">
                            <n-form>
                                <n-form-item-row label="Username">
                                    <n-input />
                                </n-form-item-row>
                                <n-form-item-row label="Password">
                                    <n-input />
                                </n-form-item-row>
                                <n-form-item-row label="Reenter Password">
                                    <n-input />
                                </n-form-item-row>
                            </n-form>
                            <n-button type="primary" block strong>
                                Sign up
                            </n-button>
                        </n-tab-pane>
                    </n-tabs>
                </n-card>
            </n-space>
        </n-layout-content>
    </n-layout>
</template>
