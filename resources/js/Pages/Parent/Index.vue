<template>

    <Head title="Parents" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Parents
                </h2>

                <button class="bg-blue-500 text-white px-4 py-2 rounded-md" @click="addParent">
                    Add Parents
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
                                    <th class="px-4 py-2">Parent Name</th>
                                    <th class="px-4 py-2">Student Name</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="parent in parent" :key="parent.id" class="hover:bg-gray-50 text-left border-b border-gray-200">
                                    <td class="px-4 py-2">{{ parent.name }}</td>
                                    <td class="px-4 py-2">{{ parent.student.name }}</td>
                                    <td class="px-4 py-2">
                                        <button class="bg-blue-500 text-white px-3 py-1 rounded-md" @click="editParent(parent.id)">Edit</button>
                                        <button class="bg-red-500 text-white px-3 py-1 rounded-md" @click="deleteParent(parent.id)">Delete</button>
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
import { onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    parent: Object,
});

const page = usePage();
const show = ref(true);

onMounted(() => {
    setTimeout(() => {
        show.value = false;
    }, 5000);
})

const addParent = () => {
    router.visit(route('parent.create'));
};

const editParent = (id) => {
    router.visit(route('parent.edit', id));
};

const deleteParent = (id) => {
    router.delete(route('parent.destroy', id), {
        onFinish: () => {
            show.value = true;
        },
        onError: () => {
            show.value = true;
            page.props.flash.error = 'Parent deleted failed';
        },
        onSuccess: () => {
            show.value = true;
            page.props.flash.success = 'Parent deleted successfully';
        },
    });
};
</script>
