<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Swal from "sweetalert2";
import axios from "axios";

const { category } = defineProps({
    category: Object,
});

const form = useForm({
    name: category.name,
});

const submitEdit = async () => {
    if (!form.name.trim()) {
        Swal.fire("Error", "Category name is required", "error");
        return;
    }

    try {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "Do you want to update this category?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, update it!",
        });

        if (result.isConfirmed) {
            const response = await axios.put(`/api/categories/${category.id}`, {
                name: form.name,
            });

            const message = response.data.message;
            let timerInterval;

            Swal.fire({
                title: "Success!",
                text: message,
                icon: "success",
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                },
                willClose: () => {
                    clearInterval(timerInterval);
                },
            });

            form.reset();
            router.visit("/categories");
        }
    } catch (error) {
        const message =
            error.response?.data?.message || "An unknown error occurred.";

        Swal.fire({
            icon: "error",
            title: "Error!",
            text: message,
        });

        console.error("Failed to update category:", message);
    }
};
</script>

<template>
    <Head title="Category Edit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Category Edit: {{ category.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submitEdit">
                            <div>
                                <InputLabel for="name" value="Category Name" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    autocomplete="name"
                                    placeholder="Enter Category"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Update Category
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
