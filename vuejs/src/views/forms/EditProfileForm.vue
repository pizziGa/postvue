<template>
    <div class="flex flex-col items-center font-semibold justify-center h-[40rem]">
        <h1 class="text-2xl">Edit your profile</h1>
        <div class="flex flex-col items-center gap-3 p-6 rounded-md">
            <input type="file" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-base p-1" name="img_path">
            <input type="text" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1" placeholder="Username" v-model="name">
            <textarea class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-28 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-base p-1" placeholder="Content" v-model="biography"></textarea>
            <button @click="updateProfile" class="rounded-md border-2 shadow-sm shadow-secondary-black border-primary-black  bg-amber-400 hover:bg-amber-500 duration-200 w-32 text-base p-1">Edit</button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import router from '@/router'

axios.defaults.withCredentials = true
axios.defaults.withXSRFToken = true

let name = ref()
let biography = ref()

async function updateProfile() {
    await axios.get('http://localhost:8000/sanctum/csrf-cookie').then(response => {
        axios.post('http://localhost:8000/api/user/update', {
            name: name.value,
            biography: biography.value
        }).then(function (response) {
            router.push({ path: '/' });
            console.log(response);
        }).catch(function (error) {
            console.log(error);
        });
    });
}
</script>