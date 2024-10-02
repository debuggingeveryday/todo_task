<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const form = useForm({
    limit: null,
});

defineProps({
    users: Object,
});

onMounted(() => {
    form.get('/user-management');
    form.cancel();
});
</script>

<template>
    <Head title="User Management" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                User Management
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl p-5 sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <table class="table-auto">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>User type</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data">
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.user_details.first_name }}</td>
                                <td>{{ user.user_details.last_name }}</td>
                                <td>{{ user.user_type }}</td>
                                <td>{{ user.created_at }}</td>
                                <td>{{ user.updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
