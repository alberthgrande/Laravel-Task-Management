<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref, onMounted } from "vue";
import Swal from "sweetalert2";
import axios from "axios";

import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

const categories = ref([]);
const loading = ref(true);

dayjs.extend(relativeTime);

onMounted(async () => {
    try {
        const res = await axios.get("/api/categories");
        categories.value = res.data.data; // 'data' key comes from Laravel Resource Collection
    } catch (error) {
        console.error("Failed to fetch categories:", error);
    } finally {
        loading.value = false;
    }
});

const deleteCategory = async (id) => {
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
            const res = await axios.delete(`/api/categories/${id}`);
            const message = res.data.message;

            categories.value = categories.value.filter((cat) => cat.id !== id);

            Swal.fire("Deleted!", message, "success");
        } catch (error) {
            const message =
                error.response?.data?.message || "An unknown error occurred.";

            Swal.fire("Error", message, "error");

            console.error("Failed to delete category:", message);
        }
    }
};
</script>

<template>
    <Head title="Category" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Category
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Link :href="route('category.create')">
                            <PrimaryButton>Create Categories</PrimaryButton>
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
                                            Category
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
                                        v-for="category in categories"
                                        :key="category.id"
                                        class="bg-white border-b hover:bg-gray-50"
                                    >
                                        <td class="px-6 py-4">
                                            {{ category.name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{
                                                dayjs(
                                                    category.created_at
                                                ).format("MMMM D, YYYY h:mm A")
                                            }}
                                            ({{
                                                dayjs(
                                                    category.created_at
                                                ).fromNow()
                                            }})
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-4">
                                                <Link
                                                    :href="
                                                        route('category.show', {
                                                            id: category.id,
                                                        })
                                                    "
                                                    class="text-blue-600 hover:underline"
                                                >
                                                    View
                                                </Link>

                                                <Link
                                                    :href="
                                                        route('category.edit', {
                                                            id: category.id,
                                                        })
                                                    "
                                                    class="text-blue-600 hover:underline"
                                                >
                                                    Edit
                                                </Link>

                                                <button
                                                    @click.prevent="
                                                        deleteCategory(
                                                            category.id
                                                        )
                                                    "
                                                    class="text-red-600 hover:underline"
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr v-if="categories.length === 0">
                                        <td
                                            colspan="3"
                                            class="px-6 py-4 text-center text-gray-500"
                                        >
                                            No categories found.
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
