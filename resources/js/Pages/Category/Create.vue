<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Swal from "sweetalert2";
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
    category: Object,
});

const form = useForm({
    name: "",
});

const countdown = ref(0);

const submitCategory = async () => {
    if (!form.name.trim()) {
        Swal.fire("Error", "Category name is required", "error");
        return;
    }

    try {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "You are about to add a new category.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, add it!",
        });

        if (result.isConfirmed) {
            await axios.post(`/api/categories`, {
                name: form.name,
            });

            Swal.fire("Success!", "Category has been added.", "success");

            form.reset();
            router.visit("/categories");
        }
    } catch (error) {
        if (error.response && error.response.data.errors) {
            form.setError(
                "name",
                error.response.data.errors.name?.[0] || "Validation error"
            );

            // setTimeout(() => {
            //     form.clearErrors("name");
            // }, 3000);

            countdown.value = 3;
            const interval = setInterval(() => {
                countdown.value--;
                if (countdown.value <= 0) {
                    form.clearErrors("name");
                    clearInterval(interval);
                }
            }, 1000);
        } else {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "There was an error creating the category.",
            });
        }
    }
};
</script>

<template>
    <Head title="Create Category" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create Category
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submitCategory">
                            <div class="mb-5">
                                <InputLabel for="name" value="Category Name" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    v-model="form.name"
                                    class="mt-1 block w-full"
                                    autocomplete="name"
                                    placeholder="Enter Category"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="
                                        form.errors.name
                                            ? `${form.errors.name} (clearing in ${countdown}s...)`
                                            : ''
                                    "
                                />
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Create Category
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
