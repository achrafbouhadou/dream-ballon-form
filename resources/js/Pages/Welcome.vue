<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Logo from '@/Components/logo.vue'
import Form from '@/Components/Form.vue'

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});


</script>

<template>
    <Head title="Welcome" />

    <div

        class="contaiener w-full h-screen md:bg-right  bg-bottom "
    >

        <div class="flex justify-between items-center p-5 ">
        <div class="w-1/2">
            <Logo />
        </div>
        <div v-if="canLogin" class="w-1/2 text-end">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link
            >


                <Link
                v-else
                    :href="route('login')"
                    class=" font-semibold  md:text-gray-600 text-black hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >



        </div>
        </div>
        <div class="w-1/2 flex items-center justify-center">
            <Form
    :client="
    {fullName: '',
    email:'',
    phone:'',
    package:'COUPLE',
    payMethode:'CASH',
    reservation:'',
    totalAmount:'',
    Note:'',
    videoLink:'',}"
    :isEdited = false />
        </div>

    </div>
</template>

<style>
.contaiener{
    background-image: url('/storage/Desktop.png') !important;
    background-size: contain;
    background-repeat: no-repeat;
}
</style>
