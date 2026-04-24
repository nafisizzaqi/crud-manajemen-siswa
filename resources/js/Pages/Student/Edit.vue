<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Edit Student
                </h2>

                <button class="bg-blue-500 text-white px-4 py-2 rounded-md" @click="backToStudents">
                    Back to Students
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
                <div v-if="page.props.flash.error && show"
                    class="fixed top-25 right-5 z-50 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 shadow-lg border border-red-300"
                    role="alert">
                    <span class="font-medium">{{ page.props.flash.error ? 'Error!' : 'Success!' }}</span> {{ page.props.flash.error || page.props.flash.success }}
                </div>
            </Transition>
            <div class="mx-auto max-w-xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700">Name</label>
                                <input v-model="form.name" type="text" id="name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div class="mb-4">
                                <label for="class" class="block text-gray-700">Class:</label>
                                    <select v-model="form.class_name" name="class_name" id="class_name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 flex-1">
                                        <option value="">Select Class</option>
                                        <option v-for="classItem in kelas" :key="classItem.id" :value="classItem.class_name">{{ classItem.class_name }}</option>
                                    </select>
                            </div>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const show = ref(true);

onMounted(() => {
    setTimeout(() => {
        show.value = false;
    }, 5000);
})
const props = defineProps({
    student: {
        type: Object,
        default: null,
    },
    kelas: {
        type: Object,
        default: null,
    },
});
// console.log(props.kelas);
console.log(props.student.class.class_name);
const form = useForm({
    name: '',
    class_name: '',
});

// const addClassModal = ref(null);

const submit = () => {
    updateStudent();
};

const updateStudent = () => {
    form.put(route('student.update', props.student.id), {
        onFinish: () => form.reset(),
    });
};

onMounted(() => {
    form.name = props.student.name;
    form.class_name = props.student.class.class_name;
});

const backToStudents = () => {
    router.visit(route('student.index'));
};

// const addClass = () => {
//     addClassModal.value.show();
// };

// onMounted(() => {
//     console.log(addClassModal.value);
// });

</script>
