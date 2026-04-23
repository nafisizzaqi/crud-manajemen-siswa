<template>

    <Head title="Class" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Class
                </h2>

                <button class="bg-blue-500 text-white px-4 py-2 rounded-md" @click="addClass">
                    Add Class
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
                    <span class="font-medium">{{ page.props.flash.success ? 'Success!' : 'Error!' }}</span> {{ page.props.flash.success || page.props.flash.error }}
                </div>
            </Transition>

            <div class="mx-auto max-w-xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-100 text-left font-semibold border-b border-gray-200">
                                    <th class="px-4 py-2">Class Name</th>
                                    <th class="px-4 py-2 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(classItem, index) in kelas" :key="classItem.id"
                                    class="hover:bg-gray-50 text-left border-b border-gray-200">
                                    <td class="px-4 py-2">{{ classItem.class_name }}</td>
                                    <td class="px-4 py-2 flex gap-2 justify-center">
                                        <button class="bg-blue-500 text-white px-3 py-1 rounded-md"
                                            @click="editClass(classItem.id)">
                                            Edit
                                        </button>
                                        <button class="bg-red-500 text-white px-3 py-1 rounded-md"
                                            @click="deleteClass(classItem.id)">
                                            Delete
                                        </button>
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
import { Head, router, usePage } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';

const page = usePage();
const show = ref(true);

onMounted(() => {
    setTimeout(() => {
        show.value = false;
    }, 5000);
})

const props = defineProps({
    kelas: Object,
});
const addClass = () => {
    router.visit(route('class.create'));
};

const editClass = (id) => {
    router.visit(route('class.edit', id));
};

const deleteClass = (id) => {
    router.delete(route('class.destroy', id), {
        onFinish: () => {
            show.value = true;
        },
        onError: () => {
            show.value = true;
            page.props.flash.error = 'Class deleted failed';
        },
        onSuccess: () => {
            show.value = true;
            page.props.flash.success = 'Class deleted successfully';
        },
    });
};
</script>

<style scoped>
.alert {
    background-color: #d4edda;
    color: #155724;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}
</style>