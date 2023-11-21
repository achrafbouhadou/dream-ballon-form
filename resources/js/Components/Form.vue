<script setup>
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3';

const props = defineProps(
    {
        client: Object,
        isEdited: Boolean
    }
)


const form = useForm({
    fullName: props.client.fullName,
    email: props.client.email,
    phone: props.client.phone,
    package: props.client.package,
    payMethode: props.client.payMethode,
    reservation: props.client.reservation,
    totalAmount: props.client.totalAmount,
    Note: props.client.Note,
});
const updateIsPayed = () => {
    form.is_payed = !form.is_payed;
};
const url = ref('')
if (props.isEdited) {

    url.value = 'client.update'
} else {
    url.value = 'client.store'
}
console.log(url)
const IsREsdenSelected = ref(false)
const isSelected = (option) => {
    return IsREsdenSelected.value === option;
};

if (props.client.payMethode && props.client.payMethode != 'RESERVATION') {
    isSelected.value = true
    IsREsdenSelected.value = false
} else {
    isSelected.value = false
    IsREsdenSelected.value = true
}


const handlePackageChange = (event) => {
    form.package = event.target.value
}



const handleOptionChange = (option) => {
    IsREsdenSelected.value = option;
    form.payMethode = option ? 'RESERVATION' : 'CASH';
    // Additional actions if needed
};


</script>
<template >
    <div class="form-container">

        <form v-if="!isEdited" @submit.prevent="form.post(route('client.store'), {
            onSuccess: () => {
                form.reset();
                console.log(form)
            }
        })">
            <h1 class="font-family primary-color md:text-3xl sm-text-lg text-sm font-bold">Personal Information:</h1>
            <div class="flex flex-col w-full">
                <label class=" mb-2 font-family primary-color font-normal" for="fullName">Full Name </label>
                <input v-model="form.fullName" class="border rounded-lg  " id="fullName" placeholder="jhon Dho" />
            </div>
            <div class="flex flex-col w-full">
                <label class=" mb-2 font-family primary-color font-normal" for="E-mail">E-mail: </label>
                <input v-model="form.email" class="border rounded-lg  " id="E-mail" placeholder="davidmartin@gmail.com" />
            </div>
            <div class="flex flex-col w-full">
                <label class=" mb-2 font-family primary-color font-normal" for="phoone">Phone number: </label>
                <input v-model="form.phone" class="border rounded-lg  " id="phoone" placeholder="+1 305 1234 5678" />

            </div>
            <div class="flex flex-col w-full">
                <label class=" mb-2 font-family primary-color font-normal" for="packge">Package:</label>
                <select v-model="form.package" id="packge"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a Package</option>
                    <option value="COUPLE">COUPLE PAKAGE - 50 EURO</option>
                    <option value="GIRLS">2 GIRLS/BOYS PAKAGE - 50 EURO </option>
                    <option value="SOLO">SOLO PAKAGE - 30 EURO </option>
                    <option value="GROUP">GROUP PAKAGE - 20 EURO / PERSON</option>
                </select>
            </div>
            <div class="flex flex-col w-full">
                <label class=" mb-2 font-family primary-color font-normal" for="total">ToTal: DH </label>
                <input v-model="form.totalAmount" class="border rounded-lg  " id="total" type="number" />
            </div>
            <div class="flex flex-col w-full">
                <label class=" mb-2 font-family primary-color font-normal" for="payMethode">Payment Method: </label>

                <div class="flex items-center mb-4">
                    <input v-bind:checked="isSelected(false)" @change="handleOptionChange(false)" id="Instant" type="radio"
                        value="" v-model="selectedOption" name="default-radio"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="Instant" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Instant</label>
                </div>
                <div class="flex items-center">
                    <input id="Residency" type="radio" v-bind:checked="isSelected(true)" @change="handleOptionChange(true)"
                        name="default-radio"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="Residency" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">From
                        Residency</label>
                </div>
                <div v-if="IsREsdenSelected">
                    <label for="Adress "
                        class="block my-2  text-sm font-medium text-gray-900 dark:text-white">Reservation</label>
                    <textarea v-model="form.reservation" id="Adress" rows="4"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="hotel or riyad ..."></textarea>
                </div>

            </div>
            <div class="flex flex-col w-full">

                <label for="Note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Note</label>
                <textarea v-model="form.Note" id="NOte" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Write your thoughts here..."></textarea>


            </div>

            <button class="w-full mt-3 text-white" type="submit">submit </button>
        </form>
        <form v-else @submit.prevent="form.put(route('client.update', client.id), {
            onSuccess: () => {
                form.reset()

            }
        })">
            <h1 class="font-family primary-color md:text-3xl sm-text-lg text-sm font-bold">Personal Information:</h1>
            <div class="flex flex-col w-full">
                <label class=" mb-2 font-family primary-color font-normal" for="fullName">Full Name </label>
                <input v-model="form.fullName" class="border rounded-lg  " id="fullName" placeholder="jhon Dho" />
            </div>
            <div class="flex flex-col w-full">
                <label class=" mb-2 font-family primary-color font-normal" for="E-mail">E-mail: </label>
                <input v-model="form.email" class="border rounded-lg  " id="E-mail" placeholder="davidmartin@gmail.com" />
            </div>
            <div class="flex flex-col w-full">
                <label class=" mb-2 font-family primary-color font-normal" for="phoone">Phone number: </label>
                <input v-model="form.phone" class="border rounded-lg  " id="phoone" placeholder="+1 305 1234 5678" />

            </div>
            <div class="flex flex-col w-full">
                <label class=" mb-2 font-family primary-color font-normal" for="packge">Package:</label>
                <select v-model="form.package" id="packge"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a Package</option>
                    <option value="COUPLE">COUPLE PAKAGE - 50 EURO</option>
                    <option value="GIRLS">2 GIRLS/BOYS PAKAGE - 50 EURO </option>
                    <option value="SOLO">SOLO PAKAGE - 30 EURO </option>
                    <option value="GROUP">GROUP PAKAGE - 20 EURO / PERSON</option>
                </select>
            </div>
            <div class="flex flex-col w-full">
                <label class=" mb-2 font-family primary-color font-normal" for="total">ToTal: DH </label>
                <input v-model="form.totalAmount" class="border rounded-lg  " id="total" type="number" />
            </div>
            <div class="flex flex-col w-full">
                <label class=" mb-2 font-family primary-color font-normal" for="payMethode">Payment Method: </label>

                <div class="flex items-center mb-4">
                    <input v-bind:checked="isSelected(false)" @change="handleOptionChange(false)" id="Instant" type="radio"
                        value="" v-model="selectedOption" name="default-radio"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="Instant" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Instant</label>
                </div>
                <div class="flex items-center">
                    <input id="Residency" type="radio" v-bind:checked="isSelected(true)" @change="handleOptionChange(true)"
                        name="default-radio"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="Residency" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">From
                        Residency</label>
                </div>
                <div v-if="IsREsdenSelected">
                    <label for="Adress "
                        class="block my-2  text-sm font-medium text-gray-900 dark:text-white">Reservation</label>
                    <textarea v-model="form.reservation" id="Adress" rows="4"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="hotel or riyad ..."></textarea>
                </div>

            </div>
            <div class="flex flex-col w-full">

                <label for="Note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Note</label>
                <textarea v-model="form.Note" id="NOte" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Write your thoughts here..."></textarea>


            </div>

            <div class="flex flex-col w-full">
                <label for="videoLink" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Video
                    link</label>
                <input class="border rounded-lg  " id="vidLink" type="number" />
            </div>
            <div class="flex  px-4 pt-4">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input v-model="checkedNames" type="checkbox" value="true" class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Payed</span>
                </label>
            </div>

            <button class="w-full mt-3 text-white" type="submit">submit </button>
        </form>
    </div>
</template>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

.form-container {
    display: inline-flex;
    padding: 48px;
    flex-direction: column;
    align-items: flex-start;
    gap: 40px;
    border-radius: 12px;
    background: #FFF;
    box-shadow: 0px 14px 31px 0px rgba(215, 82, 111, 0.10), 0px 56px 56px 0px rgba(215, 82, 111, 0.09), 0px 126px 76px 0px rgba(215, 82, 111, 0.05), 0px 224px 90px 0px rgba(215, 82, 111, 0.01), 0px 351px 98px 0px rgba(215, 82, 111, 0.00);
}

.font-family {
    font-family: 'Poppins', sans-serif;
}

.primary-color {
    color: #0E4A67;
}

input {
    border: solid 1px;
    border-color: #0E4A67;

}

button {
    display: flex;
    padding: 16px 8px;
    justify-content: center;
    align-items: center;
    gap: 8px;
    align-self: stretch;
    border-radius: 8px;
    background: linear-gradient(271deg, #F89B7F 7.64%, #F46F58 90.68%);
    backdrop-filter: blur(1.4352537393569946px);
}</style>
