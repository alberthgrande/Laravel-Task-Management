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

const form = useForm({
    name: "",
});

const countdown = ref(0);

const submitStatus = async () => {
    if (!form.name.trim()) {
        Swal.fire("Error", "Status name is required", "error");
        return;
    }

    try {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "You are about to add a new status.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, add it!",
        });

        if (result.isConfirmed) {
            const response = await axios.post(`/api/statuses`, {
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
            router.visit("/statuses");
        }
    } catch (error) {
        if (error.response && error.response.data.errors) {
            form.setError(
                "name",
                error.response.data.errors.name?.[0] || "Validation error"
            );

            countdown.value = 3;
            const interval = setInterval(() => {
                countdown.value--;
                if (countdown.value <= 0) {
                    form.clearErrors("name");
                    clearInterval(interval);
                }
            }, 1000);
        } else {
            const message =
                error.response?.data?.message || "An unknown error occurred.";

            Swal.fire({
                icon: "error",
                title: "Error!",
                text: message,
            });
        }
    }
};
</script>

<template>
    <Head title="Create Priority" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create Status
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submitStatus">
                            <div class="mb-5">
                                <InputLabel for="name" value="Status" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    v-model="form.name"
                                    class="mt-1 block w-full"
                                    autocomplete="name"
                                    placeholder="Enter Status"
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
                                    Create Status
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
