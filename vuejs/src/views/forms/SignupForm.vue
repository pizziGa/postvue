<template>
    <div class="flex flex-col items-center h-[40rem] font-semibold justify-center">
        <h1 class="text-3xl">Registration</h1>
        <div class="flex flex-col items-center text-lg gap-3 p-6 rounded-md">
            <input type="text" v-model="name" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1" placeholder="Username" name="name">
            <input type="text" v-model="email" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1" placeholder="Email" name="email">
            <input type="password" v-model="password" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1" placeholder="Password" name="password">
            <input type="date" v-model="birthdate" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1" name="birthdate">
            <button @click="signUp()" class="rounded-md border-2 shadow-sm shadow-secondary-black border-primary-black  bg-amber-400 hover:bg-amber-500 duration-200 hover:cursor-pointer w-32 text-base p-1">Sign up</button>
        </div>
        <router-link to="/login" class="flex text-sm align-middle">Do you already have an account? Log in</router-link>
    </div>
</template>

<script setup>
import axios from 'axios'
import { ref } from 'vue'

let name = ref()
let email = ref()
let password = ref()
let birthdate = ref()

function signUp() {
    axios.post('http.//localhost:9000/api/user/store', {
        name: name.value,
        email: email.value,
        password: password.value,
        birthdate: birthdate.value
    }).then(function (response) {
        console.log(response);
    }).catch(function (error) {
        console.log(error);
    });
}
</script>
