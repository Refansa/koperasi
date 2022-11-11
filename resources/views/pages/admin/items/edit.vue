<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AdminMenu from '@/views/components/admin/admin-menu.vue';
import Navbar from '@/views/components/navbar/navbar.vue';
import AdminLayout from '@/views/layouts/admin-layout.vue';
import {
    ItemProperties,
    SupplierProperties,
} from '@/scripts/composables/model';
import {
    NSpace,
    NButton,
    NH1,
    NForm,
    NCard,
    NFormItem,
    FormRules,
    NInput,
    FormInst,
    NElement,
    NInputNumber,
    NSelect,
} from 'naive-ui';
import { SelectMixedOption } from 'naive-ui/es/select/src/interface';

const props = defineProps<{
    item: ItemProperties;
    suppliers: SupplierProperties[];
}>();

const formRef = ref<FormInst | null>(null);

const form = useForm({
    name: props.item.name,
    supplier: props.item?.supplier?.id,
    stock: props.item.stock,
    price: props.item.price,
});

const supplierOptions: SelectMixedOption[] = props.suppliers.map((v) => {
    return {
        label: v.name,
        value: v.id,
    } as SelectMixedOption;
});

const formRules: FormRules = {
    name: [
        {
            required: true,
            message: 'Nama diperlukan',
            trigger: ['input', 'blur'],
        },
    ],
    supplier: [
        {
            type: 'number',
            required: true,
            message: 'Supplier diperlukan',
            trigger: ['input', 'blur'],
        },
    ],
    stock: [
        {
            type: 'number',
            required: true,
            message: 'Stok diperlukan',
            trigger: ['input', 'blur'],
        },
        {
            type: 'number',
            message: 'Hanya menerima angka',
            trigger: 'blur',
        },
    ],
    price: [
        {
            type: 'number',
            required: true,
            message: 'Harga diperlukan',
            trigger: ['input', 'blur'],
        },
        {
            type: 'number',
            message: 'Hanya menerima angka',
            trigger: 'blur',
        },
    ],
};

const submitForm = () => {
    formRef.value?.validate((errors) => {
        if (!errors) {
            form.put(`/admin/items/${props.item.id}`);
        }
    });
};

const active = 'item-data';
</script>
<template layout="default">
    <Head>
        <title>Admin | Edit Barang</title>
    </Head>
    <admin-layout>
        <template #header>
            <navbar type="admin" />
        </template>
        <template #sidebar>
            <admin-menu :active="active"> </admin-menu>
        </template>
        <template #default>
            <n-space vertical>
                <n-h1 align="center">Edit Barang</n-h1>
                <Link href="/admin/items">
                    <n-button type="primary">Kembali</n-button>
                </Link>
                <n-card>
                    <n-form
                        ref="formRef"
                        size="large"
                        :model="form"
                        :rules="formRules"
                        @submit.prevent="submitForm">
                        <n-form-item
                            path="name"
                            label="Nama Barang">
                            <n-input
                                v-model:value="form.name"
                                placeholder="Nama Barang" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.name"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.name }}
                        </n-element>
                        <n-form-item
                            path="supplier"
                            label="Supplier Barang">
                            <n-select
                                v-model:value="form.supplier"
                                filterable
                                :options="supplierOptions"
                                placeholder="Supplier Barang" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.supplier"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.supplier }}
                        </n-element>
                        <n-form-item
                            path="stock"
                            label="Stok Barang">
                            <n-input-number
                                v-model:value="form.stock"
                                placeholder="Stok Barang"
                                style="display: flex; flex: 1" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.stock"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.stock }}
                        </n-element>
                        <n-form-item
                            path="price"
                            label="Harga Barang">
                            <n-input-number
                                v-model:value="form.price"
                                placeholder="Harga Barang"
                                style="display: flex; flex: 1" />
                        </n-form-item>
                        <n-element
                            v-if="form.errors.price"
                            class="text-[var(--error-color)] mb-6">
                            {{ form.errors.price }}
                        </n-element>
                        <n-button
                            :disabled="form.processing"
                            :loading="form.processing"
                            attr-type="submit"
                            size="large"
                            block
                            type="success"
                            >Edit
                        </n-button>
                    </n-form>
                </n-card>
            </n-space>
        </template>
    </admin-layout>
</template>
