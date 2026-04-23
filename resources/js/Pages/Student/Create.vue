<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Add Student
                </h2>

                <button class="bg-blue-500 text-white px-4 py-2 rounded-md" @click="backToStudents">
                    Back to Students
                </button>
            </div>
        </template>

        <div class="py-12">
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
                                <div class="flex justify-between items-center gap-2">
                                    <select v-model="form.class_name" name="class_name" id="class_name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 flex-1">
                                        <option value="">Select Class</option>
                                        <option v-for="classItem in kelas" :key="classItem.id"
                                            :value="classItem.class_name">{{
                                                classItem.class_name }}</option>
                                    </select>
                                    <button type="button" @click="showModal = true"
                                        class="bg-blue-500 text-white rounded-md px-4 py-2">
                                        Add Class
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="showModal" @close="showModal = false">
            <div class="p-4 md:p-5 text-center">
                <div class="p-6 text-gray-900">
                    <form @submit.prevent="submitClass">
                        <div class="mb-4">
                            <label for="class" class="block text-gray-700">Class:</label>
                            <input v-model="form.class_name" type="text" id="class"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            Add Class
                        </button>
                    </form>
                </div>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import Modal from '@/Components/Modal.vue';

defineProps({
    kelas: Object,
});

const form = useForm({
    name: '',
    class_name: '',
});

const submitClass = () => {
    form.post(route("class.store"), {
        onSuccess: () => {
            showModal.value = false;
            form.reset();
            router.visit(route('student.create'));
        },
    });
};

const showModal = ref(false);
const submit = () => {
    console.log(form.data());
    form.post(route("student.store"), {
        onFinish: () => form.reset(),
    });
};

const backToStudents = () => {
    router.visit(route('student.index'));
};

</script>
