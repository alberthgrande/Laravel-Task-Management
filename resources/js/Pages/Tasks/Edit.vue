<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Swal from "sweetalert2";
import axios from "axios";

const props = defineProps({
    task: Object,
    categories: Object,
    priorities: Object,
    statuses: Object,
});

const form = useForm({
    title: props.task.title,
    description: props.task.description,
    category: props.task.category?.id ?? "", // or just `props.task.category_id` if eager-loaded with foreign key
    priority: props.task.priority?.id ?? "",
    status: props.task.status?.id ?? "",
});

const submitEdit = async () => {
    if (!form.title.trim() || !form.description.trim()) {
        Swal.fire("Error", "Title is required", "error");
        return;
    }

    try {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "Do you want to update this status?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, update it!",
        });

        if (result.isConfirmed) {
            await axios.put(`/api/tasks/${props.task.id}`, {
                title: form.title,
                description: form.description,
                category_id: form.category,
                priority_id: form.priority,
                status_id: form.status,
            });

            Swal.fire("Success!", "Task has been updated.", "success");

            form.reset();
            router.visit("/tasks");
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error!",
            text: "There was an error updating the status.",
        });
        console.error("Update failed:", error);
    }
};
</script>

<template>
    <Head title="Task Edit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Task Edit: {{ task.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submitEdit">
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
                                        :message="form.errors.title"
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
                                        :message="form.errors.description"
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
                                                v-model="form.category"
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
                                        </div>

                                        <!-- Priority -->
                                        <div class="w-full md:w-1/3">
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1"
                                            >
                                                Priority
                                            </label>
                                            <select
                                                v-model="form.priority"
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
                                        </div>

                                        <!-- Status -->
                                        <div class="w-full md:w-1/3">
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1"
                                            >
                                                Status
                                            </label>
                                            <select
                                                v-model="form.status"
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
                                        </div>
                                    </div>
                                    <div class="w-full mt-2">
                                        <InputLabel
                                            for="comment"
                                            value="Comment"
                                            class="mb-2"
                                        />
                                        <textarea
                                            name="comment"
                                            id="comment"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end mt-6">
                                <PrimaryButton
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Update Task
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
textarea {
    width: 100%;
}
</style>
