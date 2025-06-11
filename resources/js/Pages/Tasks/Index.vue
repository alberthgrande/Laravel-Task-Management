<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref, onMounted } from "vue";
import Swal from "sweetalert2";
import axios from "axios";

import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

const tasks = ref([]);
const loading = ref(true);

dayjs.extend(relativeTime);

onMounted(async () => {
    try {
        const res = await axios.get("/api/tasks");
        tasks.value = res.data.data;
    } catch (error) {
        console.error("Failed to fetch tasks:", error);
    } finally {
        loading.value = false;
    }
});

const deleteTask = async (id) => {
    const result = await Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/tasks/${id}`);
            tasks.value = tasks.value.filter((cat) => cat.id !== id);
            Swal.fire("Deleted!", "Tasks has been deleted.", "success");
        } catch (error) {
            console.error("Delete failed:", error);
            Swal.fire("Error", "Something went wrong.", "error");
        }
    }
};
</script>

<template>
    <Head title="Tasks" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tasks
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Link :href="route('task.create')">
                            <PrimaryButton>Create Tasks</PrimaryButton>
                        </Link>

                        <div
                            class="relative overflow-x-auto shadow-md sm:rounded-lg mt-7"
                        >
                            <table
                                class="w-full text-sm text-left text-gray-500"
                            >
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50"
                                >
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Title
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Description
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Category
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Priority
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Created At
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Action
                                        </th>
                                    </tr>
                                </thead>

                                <tbody v-if="loading">
                                    <tr>
                                        <td
                                            colspan="7"
                                            class="px-6 py-4 text-center"
                                        >
                                            Loading...
                                        </td>
                                    </tr>
                                </tbody>

                                <tbody v-else>
                                    <tr
                                        v-for="task in tasks"
                                        :key="task.id"
                                        class="bg-white border-b hover:bg-gray-50"
                                    >
                                        <td class="px-6 py-4">
                                            {{ task.title }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ task.description }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ task.category.name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ task.priority.name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ task.status.name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{
                                                dayjs(task.created_at).format(
                                                    "MMMM D, YYYY h:mm A"
                                                )
                                            }}
                                            ({{
                                                dayjs(
                                                    task.created_at
                                                ).fromNow()
                                            }})
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-4">
                                                <Link
                                                    :href="
                                                        route('task.show', {
                                                            id: task.id,
                                                        })
                                                    "
                                                    class="text-blue-600 hover:underline"
                                                >
                                                    View
                                                </Link>

                                                <Link
                                                    :href="
                                                        route('task.edit', {
                                                            id: task.id,
                                                        })
                                                    "
                                                    class="text-blue-600 hover:underline"
                                                >
                                                    Edit
                                                </Link>

                                                <button
                                                    @click.prevent="
                                                        deleteTask(task.id)
                                                    "
                                                    class="text-red-600 hover:underline"
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr v-if="tasks.length === 0">
                                        <td
                                            colspan="7"
                                            class="px-6 py-4 text-center text-gray-500"
                                        >
                                            No tasks found.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
