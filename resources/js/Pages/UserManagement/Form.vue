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
    name: '',
    password: '',
    firstname: '',
    email: '',
    lastname: '',
    userType: ''
})

const props = defineProps<{
    user: any;
    user_details: any;
}>();

const { user, user_details } = toRefs(props);

onMounted(() => {
    if (route().current('user-management.create')) form.transactionType = 'create';
    if (route().current('user-management.edit')) form.transactionType = 'edit';

    if (form.transactionType === 'edit') {
        const { id, name, email, user_type } = user.value;
        const { first_name, last_name } = user_details.value;

        form.id = id;
        form.name = name;
        form.email = email;
        form.firstname = first_name;
        form.lastname = last_name;
        form.userType = user_type;
    }
});

const userTypeOption = [{
    label: 'Admin',
    value: 'ADMIN_USER'
}, {
    label: 'Staff',
    value: 'STAFF_USER'
}];


function submit() {
    if (form.transactionType === 'create') {
        form.transform((data) => ({
            ...data,
            userType: form.userType
        })).post(route('user-management.store'));
    }

    if (form.transactionType === 'edit') {
        form.transform((data) => ({
            ...data,
            userType: form.userType
        })).put(route('user-management.update', user.value.id));
    }
}

</script>

<template>

    <Head title="User Management - Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                User Management - <span class="capitalize">{{ form.transactionType }}</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl p-5 sm:px-6 lg:px-8 flex justify-center">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 grid grid-cols-1 place-content-center p-5 w-1/2">
                    <form @submit.prevent="submit" class="mt-6 space-y-6 grid">
                        <div>
                            <InputLabel for="firstname" value="First name" />

                            <TextInput id="firstname" v-model="form.firstname" ref="firstname" type="text"
                                class="mt-1 block w-full" autocomplete="firstname" />

                            <InputError :message="form.errors.firstname" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="lastname" value="Last name" />

                            <TextInput id="lastname" v-model="form.lastname" ref="lastname" type="text"
                                class="mt-1 block w-full" autocomplete="lastname" />

                            <InputError :message="form.errors.lastname" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="email" value="Email" />

                            <TextInput id="email" v-model="form.email" ref="email" type="text" class="mt-1 block w-full"
                                autocomplete="email" />

                            <InputError :message="form.errors.email" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="username" value="Username" />

                            <TextInput id="username" v-model="form.name" ref="username" type="text"
                                class="mt-1 block w-full" autocomplete="username" />

                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="password" value="Password" />

                            <TextInput id="password" v-model="form.password" ref="password" type="password"
                                class="mt-1 block w-full" autocomplete="password" />

                            <InputError :message="form.errors.password" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="user-type" value="User type" />
                            <SelectInput :options="userTypeOption" v-model="form.userType" />
                            <InputError :message="form.errors.userType" class="mt-2" />
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
