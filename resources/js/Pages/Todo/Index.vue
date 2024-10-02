<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { onMounted, toRef, toRefs, watch } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { FaPen } from "vue3-icons/fa";
import { AiFillDelete } from "vue3-icons/ai";

const form = useForm({
    limit: 10,
    search: ''
});

const props = defineProps<{
    todos: any;
}>();

function fetchData() {
    form.get(route('todo-task.index'), {
        preserveState: true
    });
}

const option = {
    limit: [5, 10, 25]
};

function handleChange() {
    fetchData();
}

const { todos } = toRefs(props);

</script>

<template>

    <Head title="Todo Task" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Todo Task
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl p-5 sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 grid grid-cols-1 place-content-center p-5">
                    <PrimaryButton class="place-self-start" @click="router.visit(route('todo-task.create'))">Add
                        Task
                    </PrimaryButton>
                    <div class="grid grid-cols-2 my-5 flex">
                        <div class="w-1/2">
                            <InputLabel for="search" value="Search username" />
                            <TextInput id="search" v-model="form.search" @keyup="handleChange" ref="search" type="text"
                                class="mt-1 block w-full" autocomplete="search" />
                        </div>
                        <div class="place-self-end">
                            <InputLabel for="limit" value="Limit" />
                            <select id="limit" v-model="form.limit" @change="handleChange">
                                <option v-for="(item, index) in option.limit" :key="index" :value="item">{{ item }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <table class="table-auto table-auto">
                        <thead>
                            <tr>
                                <th class="p-2 border border-1 border-slate-900">#</th>
                                <th class="p-2 border border-1 border-slate-900">Todo</th>
                                <th class="p-2 border border-1 border-slate-900">Description</th>
                                <th class="p-2 border border-1 border-slate-900">Status</th>
                                <td class="p-2 border border-1 border-slate-900" colspan="2">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(todo, index) in todos?.data" :key="index">
                                <td class="p-2 border border-1 border-slate-900">{{ todos?.meta?.from + index }}</td>
                                <td class="p-2 border border-1 border-slate-900">{{ todo?.todo }}</td>
                                <td class="p-2 border border-1 border-slate-900">{{ todo?.description }}</td>
                                <td class="p-2 border border-1 border-slate-900">{{ todo?.status }}</td>
                                <td class="p-2 border border-1 border-slate-900">
                                    <FaPen class="text-sky-500"
                                        @click="router.visit(route('todo-task.edit', todo.id))" />
                                </td>
                                <td class="p-2 border border-1 border-slate-900"
                                    @click="router.delete(route('todo-task.destroy', todo.id))">
                                    <AiFillDelete class="text-red-500" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-5">
                        <!-- PAGINATE -->
                        <button type="button" @click="router.get(todos?.links?.first)"
                            class="border border-slate-900 px-2">First
                            page</button>
                        <button type="button" v-for="item in todos?.meta?.links" @click="router.get(item?.url)"
                            class="px-2 border border-slate-900" :class="{ 'bg-slate-900 text-white': item?.active }">
                            <span v-html="item.label"></span>
                        </button>
                        <button type="button" @click="router.get(todos?.links?.last)"
                            class="border border-slate-900 px-2">Last
                            page</button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
