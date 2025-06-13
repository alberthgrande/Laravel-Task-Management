<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    task: Object,
});
</script>

<template>
    <Head title="Show Task" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Show Task
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="py-12 max-w-4xl mx-auto">
                        <h1 class="text-2xl font-bold mb-4">Task Details</h1>

                        <p><strong>Title:</strong> {{ task.title }}</p>
                        <p>
                            <strong>Description:</strong>
                            {{ task.description }}
                        </p>
                        <p>
                            <strong>Category:</strong>
                            {{ task.category?.name || "N/A" }}
                        </p>
                        <p>
                            <strong>Priority:</strong>
                            {{ task.priority?.name || "N/A" }}
                        </p>
                        <p>
                            <strong>Status:</strong>
                            {{ task.status?.name || "N/A" }}
                        </p>

                        <div class="flex justify-end mt-6">
                            <PrimaryButton @click="$inertia.visit('/tasks')">
                                Back
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
