<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { computed, onMounted, toRefs } from 'vue';

const form = useForm({
    transactionType: '',
    id: '',
    todo: '',
    description: '',
    status: ''
})

const props = defineProps<{
    data: any;
}>();

const { data } = toRefs(props);

onMounted(() => {
    if (route().current('todo-task.create')) form.transactionType = 'create';
    if (route().current('todo-task.edit')) form.transactionType = 'edit';

    if (form.transactionType === 'edit') {
        const { id, todo, description, status } = data.value;
        form.id = id;
        form.todo = todo;
        form.description = description;
        form.status = status;
    }
});

const statusTypeOption = [{
    label: 'Todo',
    value: 'TODO'
}, {
    label: 'In Progress',
    value: 'IN_PROGRESS'
}, {
    label: 'Done',
    value: 'DONE'
}];


function submit() {
    if (form.transactionType === 'create') {
        form.post(route('todo-task.store'));
    }

    if (form.transactionType === 'edit') {
        form.put(route('todo-task.update', data.value.id));
    }
}

</script>

<template>

    <Head :title="`Todo Task - ${form.transactionType}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Todo Task - <span class="capitalize">{{ form.transactionType }}</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl p-5 sm:px-6 lg:px-8 flex justify-center">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 grid grid-cols-1 place-content-center p-5 w-1/2">
                    <form @submit.prevent="submit" class="mt-6 space-y-6 grid">
                        <div>
                            <InputLabel for="todo" value="Todo" />

                            <TextInput id="todo" v-model="form.todo" ref="todo" type="text" class="mt-1 block w-full"
                                autocomplete="todo" />

                            <InputError :message="form.errors.todo" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="description" value="Description" />

                            <textarea id="description" v-model="form.description" ref="description" type="text"
                                class="mt-1 block w-full" autocomplete="description"></textarea>

                            <InputError :message="form.errors.description" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="status" value="Status" />
                            <SelectInput :options="statusTypeOption" v-model="form.status" />
                            <InputError :message="form.errors.status" class="mt-2" />
                        </div>
                        <div class="place-self-end">
                            <PrimaryButton>Submit</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
