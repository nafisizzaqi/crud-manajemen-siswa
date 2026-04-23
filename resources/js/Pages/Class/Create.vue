<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const show = ref(true);

onMounted(() => {
    setTimeout(() => {
        show.value = false;
    }, 5000);
})
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