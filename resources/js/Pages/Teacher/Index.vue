<template>

    <Head title="Teachers" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Teachers
                </h2>

                <button class="bg-blue-500 text-white px-4 py-2 rounded-md" @click="addTeacher">
                    Add Teacher
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
                    class="fixed top-20 right-5 z-50 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 shadow-lg border border-green-300"
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
                                    <th class="px-4 py-2">Teacher Name</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(group, index) in groupedData" :key="index"
                                    class="hover:bg-gray-50 text-left border-b border-gray-200">
                                    <td class="px-4 py-2">{{ group.className }}</td>
                                    <td class="px-4 py-2 flex-col gap-2">
                                        <div v-for="teacher in group.teachers" :key="teacher.id" class="p-2">
                                            <span>{{ teacher.name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 flex-col gap-2">
                                        <div v-for="teacher in group.teachers" :key="teacher.id"
                                            class="flex items-center gap-2 justify-between">
                                            <div class="flex items-center p-1 gap-2">
                                                <button class="bg-blue-500 text-white px-3 py-1 rounded-md"
                                                    @click="editTeacher(teacher.id)">Edit</button>
                                                <button class="bg-red-500 text-white px-3 py-1 rounded-md"
                                                    @click="deleteTeacher(teacher.id)">Delete</button>
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

const page = usePage();
const show = ref(true);

onMounted(() => {
    setTimeout(() => {
        show.value = false;
    }, 5000);
})
const props = defineProps({
    teachers: {
        type: Object,
        default: [],
    },
    groupTeachers: {
        type: Object,
        default: [],
    },
});
console.log(props.teachers);
console.log(props.groupTeachers);
const groupedData = computed(() => {
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

const addTeacher = () => {
    router.visit(route('teacher.create'));
};
const editTeacher = (id) => {
    router.visit(route('teacher.edit', id));
};

const deleteTeacher = (id) => {
    router.delete(route('teacher.destroy', id), {
        onFinish: () => {
            show.value = true;
        },
        onError: () => {
            show.value = true;
            page.props.flash.error = 'Teacher deleted failed';
        },
        onSuccess: () => {
            show.value = true;
            page.props.flash.success = 'Teacher deleted successfully';
        },
    });
};
</script>
