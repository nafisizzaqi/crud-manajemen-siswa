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
            <Transition enter-active-class="transition duration-300 ease-out"
                enter-from-class="transform translate-x-10 opacity-0"
                enter-to-class="transform translate-x-0 opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="transform translate-x-0 opacity-100"
                leave-to-class="transform translate-x-10 opacity-0">
                <div v-if="page.props.flash.success && show"
                    class="fixed top-25 right-5 z-50 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 shadow-lg border border-green-300"
                    role="alert">
                    <span class="font-medium">{{ page.props.flash.success ? 'Success!' : 'Error!' }}</span> {{
                        page.props.flash.success || page.props.flash.error }}
                </div>
            </Transition>
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-100 text-left font-semibold border-b border-gray-200">
                                    <th class="px-4 py-2">Class</th>
                                    <th class="px-4 py-2">Student Name</th>
                                    <th class="px-4 py-2">Parent Name</th>
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
                                            class="p-2 flex flex-col gap-2">
                                            <span>{{ student.parent ? student.parent.name : '-' }}</span>
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
import { computed, onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    students: Object,
    groupStudents: Object,
});
console

const page = usePage();
const show = ref(true);

onMounted(() => {
    setTimeout(() => {
        show.value = false;
    }, 5000);
})
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
    router.delete(route('student.destroy', id), {
        onFinish: () => {
            show.value = true;
        },
        onError: () => {
            show.value = true;
            page.props.flash.error = 'Student deleted failed';
        },
        onSuccess: () => {
            show.value = true;
            page.props.flash.success = 'Student deleted successfully';
        },
    });
};
</script>
