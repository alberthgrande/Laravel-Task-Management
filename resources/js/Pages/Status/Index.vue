<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref, onMounted } from "vue";
import Swal from "sweetalert2";
import axios from "axios";

import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

const statuses = ref([]);
const loading = ref(true);

dayjs.extend(relativeTime);

onMounted(async () => {
    try {
        const res = await axios.get("/api/statuses");
        statuses.value = res.data.data;
    } catch (error) {
        console.error("Failed to fetch statuses:", error);
    } finally {
        loading.value = false;
    }
});

const deleteStatus = async (id) => {
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
            await axios.delete(`/api/statuses/${id}`);
            statuses.value = statuses.value.filter((cat) => cat.id !== id);
            Swal.fire("Deleted!", "Status has been deleted.", "success");
        } catch (error) {
            console.error("Delete failed:", error);
            Swal.fire("Error", "Something went wrong.", "error");
        }
    }
};
</script>

<template>
    <Head title="Status" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Status
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Link :href="route('status.create')">
                            <PrimaryButton>Create Statuses</PrimaryButton>
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
                                            colspan="3"
                                            class="px-6 py-4 text-center"
                                        >
                                            Loading...
                                        </td>
                                    </tr>
                                </tbody>

                                <tbody v-else>
                                    <tr
                                        v-for="status in statuses"
                                        :key="status.id"
                                        class="bg-white border-b hover:bg-gray-50"
                                    >
                                        <td class="px-6 py-4">
                                            {{ status.name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{
                                                dayjs(status.created_at).format(
                                                    "MMMM D, YYYY h:mm A"
                                                )
                                            }}
                                            ({{
                                                dayjs(
                                                    status.created_at
                                                ).fromNow()
                                            }})
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-4">
                                                <Link
                                                    :href="
                                                        route('status.edit', {
                                                            id: status.id,
                                                        })
                                                    "
                                                    class="text-blue-600 hover:underline"
                                                >
                                                    Edit
                                                </Link>

                                                <button
                                                    @click.prevent="
                                                        deleteStatus(status.id)
                                                    "
                                                    class="text-red-600 hover:underline"
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr v-if="statuses.length === 0">
                                        <td
                                            colspan="3"
                                            class="px-6 py-4 text-center text-gray-500"
                                        >
                                            No statuses found.
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
