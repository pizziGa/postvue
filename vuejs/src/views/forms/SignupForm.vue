<template>
    <div class="flex flex-col items-center h-[40rem] font-semibold justify-center">
        <h1 class="text-3xl">Registration</h1>
        <div class="flex flex-col items-center text-lg gap-3 p-6 rounded-md">
            <input type="text" v-model="name" placeholder="Username" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1">
            <input type="text" v-model="email" placeholder="Email" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1">
            <input type="password" v-model="password" placeholder="Password" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1">
            <input type="date" v-model="birthdate" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1">
            <button @click="storeUser.actions.signup(name, email, password, birthdate)" class="rounded-md border-2 shadow-sm shadow-secondary-black border-primary-black  bg-amber-400 hover:bg-amber-500 duration-200 hover:cursor-pointer w-32 text-base p-1">Sign up</button>
        </div>
        <router-link to="/login" class="flex text-sm align-middle">Do you already have an account? Log in</router-link>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useUserStore } from '../../stores/UserStore';

const storeUser = new useUserStore()

let name = ref()
let email = ref()
let password = ref()
let birthdate = ref()

</script>
