<template>

    <Head title="Students" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Students
                </h2>

                <button class="bg-blue-500 text-white px-4 py-2 rounded-md" @click="addStudent">
                    Add Student
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
                                    <th class="px-4 py-2">Class</th>
                                    <th class="px-4 py-2">Student Name</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(group, index) in groupedData" :key="index"
                                    class="hover:bg-gray-50 text-left border-b border-gray-200">
                                    <td class="px-4 py-2">{{ group.className }}</td>
                                    <td class="px-4 py-2 flex-col gap-2">
                                        <div v-for="student in group.students" :key="student.id" class="p-2">
                                            <span>{{ student.name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 flex-col gap-2">
                                        <div v-for="student in group.students" :key="student.id"
                                            class="flex items-center gap-2 justify-between">
                                            <div class="flex items-center p-1 gap-2">
                                                <button class="bg-blue-500 text-white px-3 py-1 rounded-md"
                                                    @click="editStudent(student.id)">Edit</button>
                                                <button class="bg-red-500 text-white px-3 py-1 rounded-md"
                                                    @click="deleteStudent(student.id)">Delete</button>
                                            </div>
                                        </div>
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
import { computed } from 'vue';

const props = defineProps({
    students: Object,
    groupStudents: Object,
});
// console.log(props.students);

const groupedData = computed(() => {
    const result = {};
    props.students.forEach(item => {
        if (!result[item.class_id]) {
            result[item.class_id] = {
                className: item.class.class_name,
                students: [item],
            }
        } else {
            result[item.class_id].students.push(item);
        }
    })
    return Object.values(result);
});
console.log('groupedData', groupedData.value);
const addStudent = () => {
    router.visit(route('student.create'));
};

const editStudent = (id) => {
    router.visit(route('student.edit', id));
};

const deleteStudent = (id) => {
    router.delete(route('student.destroy', id));
};
</script>
