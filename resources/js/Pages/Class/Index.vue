<template>

    <Head title="Class" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Class
                </h2>

                <button class="bg-blue-500 text-white px-4 py-2 rounded-md" @click="addClass">
                    Add Class
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-100 text-left font-semibold border-b border-gray-200">
                                    <th class="px-4 py-2">No</th>
                                    <th class="px-4 py-2">Class Name</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(classItem, index) in kelas" :key="classItem.id" class="hover:bg-gray-50 text-left border-b border-gray-200">
                                    <td class="px-4 py-2">{{ index + 1 }}</td>
                                    <td class="px-4 py-2">{{ classItem.class_name }}</td>
                                    <td class="px-4 py-2 flex gap-2">
                                        <button class="bg-blue-500 text-white px-3 py-1 rounded-md" @click="editClass(classItem.id)">
                                            Edit
                                        </button>
                                        <button class="bg-red-500 text-white px-3 py-1 rounded-md" @click="deleteClass(classItem.id)">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    kelas: Object,
});
const addClass = () => {
    router.visit(route('class.create'));
};

const editClass = (id) => {
    router.visit(route('class.edit', id));
};

const deleteClass = (id) => {
    router.delete(route('class.destroy', id));
};
</script>
