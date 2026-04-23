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
                                    <tr v-for="(group, index) in mergedData" :key="index" class="hover:bg-gray-50 text-left border-b border-gray-200">
                                        <!-- <pre>{{ group }}</pre> -->
                                        <td class="px-4 py-2">{{ group.className }}</td>
                                        <td class="px-4 py-2 flex-col gap-2">

                                            <div v-for="student in group.students" :key="student.id" class="p-2 flex flex-col gap-2">
                                                <span v-for="student in student.students" :key="student.id">{{ student.name ? student.name : '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 flex-col gap-2">
                                            <div v-for="teacher in group.teachers" :key="teacher.id" class="p-2 flex flex-col gap-2">
                                                <span v-for="teacher in teacher.teachers" :key="teacher.id">{{ teacher.name ? teacher.name : '-' }}</span>
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

const groupStudents = computed(() => {
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
console.log('groupStudents', groupStudents.value);
const groupTeachers = computed(() => {
    const result = {};
    props.teachers.forEach(item => {
        if (!result[item.class_id]) {
            result[item.class_id] = {
                className: item.class.class_name,
                teachers: [item],
            }
        } else {
            result[item.class_id].teachers.push(item);
        }
    })
    return Object.values(result);
});
console.log('groupTeachers', groupTeachers.value);

const mergedData = computed(() => {
  const map = new Map();

  groupStudents.value.forEach(student => {
    if (!map.has(student.className)) {
      map.set(student.className, { className: student.className, students: [], teachers: [] });
    }
    map.get(student.className).students.push(student);
  });

  groupTeachers.value.forEach(teacher => {
    if (!map.has(teacher.className)) {
      map.set(teacher.className, { className: teacher.className, students: [], teachers: [] });
    }
    map.get(teacher.className).teachers.push(teacher);
  });

  return Array.from(map.values());
});
console.log('mergedData', mergedData.value);

const uniqueClass = [...new Set(
    props.groupData
            .flatMap(item => item)
            .map(item => item.class.class_name)
        )];
// console.log('uniqueClass', uniqueClass);
</script>
