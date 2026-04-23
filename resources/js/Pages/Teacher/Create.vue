<template>

    <Head title="Teachers" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Add Teacher
                </h2>

                <button class="bg-blue-500 text-white px-4 py-2 rounded-md" @click="backToTeachers">
                    Back to Teachers
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
                    class="fixed top-20 right-5 z-50 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 shadow-lg border border-red-300"
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
                                <div class="flex justify-between items-center gap-2">
                                    <select v-model="form.class_name" name="class_name" id="class_name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 flex-1">
                                        <option value="">Select Class</option>
                                        <option v-for="kelas in kelas" :key="kelas.id" :value="kelas.class_name">{{
                                            kelas.class_name }}</option>
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
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const show = ref(true);

onMounted(() => {
    setTimeout(() => {
        show.value = false;
    }, 5000);
})
const showModal = ref(false);

defineProps({
    kelas: Object,
});

const form = useForm({
    name: '',
    class_name: '',
});

const submit = () => {
    form.post(route("teacher.store"), {
        onFinish: () => form.reset(),
    });
};

const backToTeachers = () => {
    router.visit(route('teacher.index'));
};

const submitClass = () => {
    form.post(route("class.store"), {
        onSuccess: () => {
            showModal.value = false;
            form.reset();
            router.visit(route('teacher.create'));
        },
    });
};
</script>
