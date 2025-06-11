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
    categories: Object,
    priorities: Object,
    statuses: Object,
});

const form = useForm({
    title: "",
    description: "",
    category_id: "",
    priority_id: "",
    status_id: "",
});

const countdown = ref(0);

const submitTask = async () => {
    try {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "You are about to add a new Task.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, add it!",
        });

        if (result.isConfirmed) {
            await axios.post(`/api/tasks`, {
                title: form.title,
                description: form.description,
                category_id: form.category_id,
                priority_id: form.priority_id,
                status_id: form.status_id,
            });

            Swal.fire("Success!", "Task has been added.", "success");

            form.reset();
            router.visit("/tasks");
        }
    } catch (error) {
        if (error.response && error.response.data.errors) {
            form.setError(
                "title",
                error.response.data.errors.title?.[0] || "Validation error"
            );

            form.setError(
                "description",
                error.response.data.errors.description?.[0] ||
                    "Validation error"
            );

            form.setError(
                "category_id",
                error.response.data.errors.category_id?.[0] ||
                    "Validation error"
            );

            form.setError(
                "priority_id",
                error.response.data.errors.priority_id?.[0] ||
                    "Validation error"
            );

            form.setError(
                "status_id",
                error.response.data.errors.status_id?.[0] || "Validation error"
            );

            // setTimeout(() => {
            //     form.clearErrors("name");
            // }, 3000);

            countdown.value = 3;
            const interval = setInterval(() => {
                countdown.value--;
                if (countdown.value <= 0) {
                    form.clearErrors("title");
                    form.clearErrors("description");
                    form.clearErrors("category_id");
                    form.clearErrors("priority_id");
                    form.clearErrors("status_id");

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
    <Head title="Create Task" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create Task
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submitTask">
                            <div class="grid gap-6 mb-6 sm:grid-cols-2">
                                <!-- Title -->
                                <div class="w-full">
                                    <InputLabel for="title" value="Title" />
                                    <TextInput
                                        id="title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.title"
                                        autocomplete="title"
                                        placeholder="Enter Title"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="
                                            form.errors.title
                                                ? `${form.errors.title} (clearing in ${countdown}s...)`
                                                : ''
                                        "
                                    />
                                </div>

                                <!-- Description -->
                                <div class="w-full">
                                    <InputLabel
                                        for="description"
                                        value="Description"
                                    />
                                    <TextInput
                                        id="description"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.description"
                                        autocomplete="description"
                                        placeholder="Enter Description"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="
                                            form.errors.description
                                                ? `${form.errors.description} (clearing in ${countdown}s...)`
                                                : ''
                                        "
                                    />
                                </div>

                                <!-- Dropdowns: Category, Priority, Status -->
                                <div class="w-full sm:col-span-2">
                                    <div
                                        class="flex flex-col md:flex-row gap-4"
                                    >
                                        <!-- Category -->
                                        <div class="w-full md:w-1/3">
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1"
                                            >
                                                Category
                                            </label>
                                            <select
                                                name="category_id"
                                                v-model="form.category_id"
                                                class="w-full border rounded p-2 focus:ring focus:ring-indigo-200"
                                            >
                                                <option disabled value="">
                                                    Select Category
                                                </option>
                                                <option
                                                    v-for="c in categories"
                                                    :key="c.id"
                                                    :value="c.id"
                                                >
                                                    {{ c.name }}
                                                </option>
                                            </select>
                                            <InputError
                                                class="mt-2"
                                                :message="
                                                    form.errors.category_id
                                                        ? `${form.errors.category_id} (clearing in ${countdown}s...)`
                                                        : ''
                                                "
                                            />
                                        </div>

                                        <!-- Priority -->
                                        <div class="w-full md:w-1/3">
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1"
                                            >
                                                Priority
                                            </label>
                                            <select
                                                name="priority_id"
                                                v-model="form.priority_id"
                                                class="w-full border rounded p-2 focus:ring focus:ring-indigo-200"
                                            >
                                                <option disabled value="">
                                                    Select Priority
                                                </option>
                                                <option
                                                    v-for="p in priorities"
                                                    :key="p.id"
                                                    :value="p.id"
                                                >
                                                    {{ p.name }}
                                                </option>
                                            </select>
                                            <InputError
                                                class="mt-2"
                                                :message="
                                                    form.errors.priority_id
                                                        ? `${form.errors.priority_id} (clearing in ${countdown}s...)`
                                                        : ''
                                                "
                                            />
                                        </div>

                                        <!-- Status -->
                                        <div class="w-full md:w-1/3">
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1"
                                            >
                                                Status
                                            </label>
                                            <select
                                                name="status_id"
                                                v-model="form.status_id"
                                                class="w-full border rounded p-2 focus:ring focus:ring-indigo-200"
                                            >
                                                <option disabled value="">
                                                    Select Status
                                                </option>
                                                <option
                                                    v-for="s in statuses"
                                                    :key="s.id"
                                                    :value="s.id"
                                                >
                                                    {{ s.name }}
                                                </option>
                                            </select>
                                            <InputError
                                                class="mt-2"
                                                :message="
                                                    form.errors.status_id
                                                        ? `${form.errors.status_id} (clearing in ${countdown}s...)`
                                                        : ''
                                                "
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end mt-6">
                                <PrimaryButton
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Create Task
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
