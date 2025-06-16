<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref, onMounted } from "vue";
import Swal from "sweetalert2";
import axios from "axios";

import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

const priorities = ref([]);
const loading = ref(true);

dayjs.extend(relativeTime);

onMounted(async () => {
    try {
        const res = await axios.get("/api/priorities");
        priorities.value = res.data.data;
    } catch (error) {
        console.error("Failed to fetch priorities:", error);
    } finally {
        loading.value = false;
    }
});

const deletePriority = async (id) => {
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
            const response = await axios.delete(`/api/priorities/${id}`);
            priorities.value = priorities.value.filter((cat) => cat.id !== id);

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
        } catch (error) {
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
    <Head title="Priority" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Priority
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Link :href="route('priority.create')">
                            <PrimaryButton>Create Priorities</PrimaryButton>
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
                                            Priority
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
                                            colspan="3"
                                            class="px-6 py-4 text-center"
                                        >
                                            Loading...
                                        </td>
                                    </tr>
                                </tbody>

                                <tbody v-else>
                                    <tr
                                        v-for="priority in priorities"
                                        :key="priority.id"
                                        class="bg-white border-b hover:bg-gray-50"
                                    >
                                        <td class="px-6 py-4">
                                            {{ priority.name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{
                                                dayjs(
                                                    priority.created_at
                                                ).format("MMMM D, YYYY h:mm A")
                                            }}
                                            ({{
                                                dayjs(
                                                    priority.created_at
                                                ).fromNow()
                                            }})
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-4">
                                                <Link
                                                    :href="
                                                        route('priority.show', {
                                                            id: priority.id,
                                                        })
                                                    "
                                                    class="text-blue-600 hover:underline"
                                                >
                                                    View
                                                </Link>

                                                <Link
                                                    :href="
                                                        route('priority.edit', {
                                                            id: priority.id,
                                                        })
                                                    "
                                                    class="text-blue-600 hover:underline"
                                                >
                                                    Edit
                                                </Link>

                                                <button
                                                    @click.prevent="
                                                        deletePriority(
                                                            priority.id
                                                        )
                                                    "
                                                    class="text-red-600 hover:underline"
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr v-if="priorities.length === 0">
                                        <td
                                            colspan="3"
                                            class="px-6 py-4 text-center text-gray-500"
                                        >
                                            No priorities found.
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
