<template>
    <div class="flex flex-col items-center font-semibold justify-center h-[40rem]">
        <h1 class="text-3xl">Login</h1>
        <div class="flex flex-col items-center text-lg gap-3 p-6 rounded-md">
            <input type="text" v-model="email" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1" placeholder="Email" name="email">
            <input type="password" v-model="password" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1" placeholder="Password" name="password">
            <button @click="logIn" class="rounded-md border-2 shadow-sm shadow-secondary-black border-primary-black bg-amber-400 hover:bg-amber-500 duration-200 hover:cursor-pointer w-32 text-base p-1">Login</button>
        </div>
        <router-link to="/signup" class="flex text-sm align-middle">Do you not have an account? Sign up</router-link>
    </div>
</template>

<script setup>
import axios from 'axios'
import { ref } from 'vue'
import router from '@/router'

axios.defaults.withCredentials = true
axios.defaults.withXSRFToken = true

let email = ref()
let password = ref()

async function logIn() {
    await axios.get('http://localhost:8000/sanctum/csrf-cookie').then(response => {
        axios.post('http://localhost:8000/api/user/authenticate', {
            email: email.value,
            password: password.value
        }).then(function (response) {
            router.push({ path: '/' });
            console.log(response);
        }).catch(function (error) {
            console.log(error);
        });
        
    });
}
</script>
