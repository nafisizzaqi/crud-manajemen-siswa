<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';

const form = useForm({
    // name: '',
    class_name: '',
});

const submit = () => {
    console.log(form.data());
    form.post(route("class.store"), {
        onFinish: () => form.reset(),
    });
};

const backToClassIndex = () => {
    router.visit(route('class.index'));
};

</script>

<template>

    <Head title="Class" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Add Class
                </h2>

                <button class="bg-blue-500 text-white px-4 py-2 rounded-md" @click="backToClassIndex">
                    Back to Class Index
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label for="class" class="block text-gray-700">Class:</label>
                                <input v-model="form.class_name" type="text" id="class" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
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