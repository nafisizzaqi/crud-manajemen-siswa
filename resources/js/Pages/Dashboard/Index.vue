<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-2xl font-bold">Welcome to the Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-100 text-left font-semibold border-b border-gray-200">
                                        <th class="px-4 py-2">Class Name</th>
                                        <th class="px-4 py-2">Student Name</th>
                                        <th class="px-4 py-2">Teacher Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(group, index) in mergedData" :key="index"
                                    {{ mergedData }}
                                        class="hover:bg-gray-50 text-left border-b border-gray-200">
                                        <td class="px-4 py-2">{{ group.className }}</td>
                                        <td class="px-4 py-2 flex-col gap-2">

                                            <div v-if="group.students.length > 0" v-for="student in group.students" :key="student.id"
                                                class="p-2 flex flex-col gap-2">
                                                <span>{{ student.name }}</span>
                                            </div>
                                            <div v-else class="p-2">
                                                -
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 flex-col gap-2">
                                            <div v-if="group.teachers.length > 0" v-for="teacher in group.teachers" :key="teacher.id"
                                                class="p-2 flex flex-col gap-2">
                                                <span>{{ teacher.name  }}</span>
                                            </div>
                                            <div v-else class="p-2">
                                                -
                                            </div>
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
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
const props = defineProps({
    groupData: Object,
    students: Object,
    teachers: Object,
});

const mergedData = computed(() => {
    const uniqueClass = [...new Set(
        props.groupData
                .flatMap(item => item)
                .map(item => item.class.class_name)
            )];
    const map = new Map();

    props.students.forEach(student => {
        if (!map.has(student.class.class_name)) {
            map.set(student.class.class_name, { className: student.class.class_name, students: [], teachers: [] });
        }
        map.get(student.class.class_name).students.push(student);
    });

    props.teachers.forEach(teacher => {
        if (!map.has(teacher.class.class_name)) {
            map.set(teacher.class.class_name, { className: teacher.class.class_name, students: [], teachers: [] });
        }
        map.get(teacher.class.class_name).teachers.push(teacher);
    });

    const result = Array.from(map.values());
    return result;
});
</script>
