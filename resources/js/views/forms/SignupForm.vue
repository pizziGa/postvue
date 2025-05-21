<template>
    <div class="flex flex-col items-center h-[40rem] font-semibold justify-center text-timberwolf">
        <h1 class="text-3xl text-timberwolf">Registration</h1>
        <div class="flex flex-col items-center text-lg gap-3 p-6 rounded-md">
            <input type="text" v-model="name" placeholder="Username" class="border-b-2 w-80 h-12 focus:outline-none border-dark-pastel-green bg-nightmare placeholder:font-semibold placeholder:text-lg placeholder:text-timberwolf p-1">
            <input type="text" v-model="email" placeholder="Email" class="border-b-2 w-80 h-12 focus:outline-none border-dark-pastel-green bg-nightmare placeholder:font-semibold placeholder:text-lg placeholder:text-timberwolf p-1">
            <input type="password" v-model="password" placeholder="Password" class="border-b-2 focus:outline-none w-80 h-12 border-dark-pastel-green bg-nightmare placeholder:font-semibold placeholder:text-lg placeholder:text-timberwolf p-1">
            <input type="date" v-model="birthdate" class="border-b-2 w-80 h-12 border-dark-pastel-green focus:outline-none bg-nightmare placeholder:font-semibold placeholder:text-lg placeholder:text-timberwolf p-1">
            <button @click="storeUser.actions.signup(name, email, password, birthdate)" class="rounded-md text-timberwolf bg-dark-pastel-green hover:text-mantis duration-200 w-32 text-base p-1">Sign up</button>
        </div>
        <router-link to="/login" class="flex text-sm align-middle hover:text-dark-pastel-green duration-200">Do you already have an account? Log in</router-link>
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
