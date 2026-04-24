<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const show = ref(true);

const props = defineProps({
    parent: Object,
    student: Object,
});

onMounted(() => {
    setTimeout(() => {
        show.value = false;
    }, 5000);
})
const form = useForm({
    student_id: props.parent.student_id,
    name: props.parent.name,
});

const submit = () => {
    form.put(route("parent.update", props.parent.id), {
        onFinish: () => form.reset(),
    });
};

const backToParentIndex = () => {
    router.visit(route('parent.index'));
};

</script>

<template>

    <Head title="Class" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Edit Parent
                </h2>

                <button class="bg-blue-500 text-white px-4 py-2 rounded-md" @click="backToParentIndex">
                    Back to Parent Index
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
                                <label for="class" class="block text-gray-700">Parent:</label>
                                <input v-model="form.name" type="text" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div class="mb-4">
                                <label for="class" class="block text-gray-700">Student:</label>
                                <div class="flex justify-between items-center gap-2">
                                    <select v-model="form.student_id" name="student_id" id="student_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 flex-1">
                                        <option value="">Select Student</option>
                                        <option v-for="student in props.student" :key="student.id"
                                            :value="student.id">{{
                                                student.name }}</option>
                                    </select>
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
    </AuthenticatedLayout>
</template>