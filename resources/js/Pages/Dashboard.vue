<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import Form from '@/Components/Form.vue'
import DropdownLink from '@/Components/DropdownLink.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';
import { useForm } from '@inertiajs/vue3';

defineProps(['clients']);

const form = useForm({
    date: Object,

});
const showModal = ref(false)

const selectedClient = ref({})

const edite = async (id) => {
    try {
        const response = await axios.get('/client/' + id);
        selectedClient.value = response.data;
        showModal.value = true;
    } catch (error) {
        console.error('Error fetching client data:', error);
        // Handle the error if necessary
    }
};

const closeModal = () => {
    showModal.value = false;


};
const date = ref();
const upadteDate = async () => {
    try {
        // Ensure date.value is a Date object
        if (!(date.value instanceof Date)) {
            date.value = new Date(date.value);
        }

        // Adjust the date to account for the timezone offset
        const timezoneOffset = date.value.getTimezoneOffset() * 60000; // offset in milliseconds
        const adjustedDate = new Date(date.value.getTime() - timezoneOffset);

        // Format the date to YYYY-MM-DD
        const formattedDate = adjustedDate.toISOString().split('T')[0];
        form.date = formattedDate;
        console.log(form.date);

        form.post(route('client.data-filter'), {
            onSuccess: () => {
                console.log(formattedDate);
                form.reset();
                console.log(form);
            }
        });
    } catch (error) {
        console.error('Error fetching client data:', error);
        // Handle the error if necessary
    }
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="card m-5 flex justify-content-center">
            <Calendar v-model="date" showIcon @date-select="upadteDate" />
        </div>

        <div class="py-12">


            <div class="ml-4 grid grid-cols-2 md:grid-cols-3 gap-4">
                <div v-for="client in clients" :key="client.id"
                    class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                    <div class="flex flex-col items-center pb-10">

                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ client.fullName }}</h5>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ client.email }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ client.phone }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ client.package }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ client.payMethode }} </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ client.reservation }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ client.totalAmount }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ client.Note }}</span>
                        <div class="flex mt-4 md:mt-6">
                            <button type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                @click="edite(client.id)">Edite</button>

                            <DropdownLink as="button" :href="route('client.destroy', client.id)" method="delete">
                                Delete
                            </DropdownLink>

                        </div>
                    </div>
                </div>



            </div>
            <Modal :show="showModal" @close="closeModal">
                <div class="p-6 flex justify-center items-center flex-col">


                    <Form :client="selectedClient" :isEdited=true />
                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
