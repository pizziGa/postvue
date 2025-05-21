<template>
    <div class="flex flex-col items-center font-semibold justify-center h-[40rem] text-timberwolf">
        <h1 class="text-3xl text-timberwolf">Login</h1>
        <div class="flex flex-col items-center text-lg gap-3 p-6 rounded-md">
            <input type="text" v-model="email" placeholder="Email" class="border-b-2 w-80 h-12 focus:outline-none border-dark-pastel-green bg-nightmare placeholder:font-semibold placeholder:text-lg placeholder:text-timberwolf p-1">
            <input type="password" v-model="password" placeholder="Password" class="border-b-2 w-80 h-12 focus:outline-none border-dark-pastel-green bg-nightmare placeholder:font-semibold placeholder:text-lg placeholder:text-timberwolf p-1">
            <button @click="storeUser.actions.authenticate(email, password)" class="rounded-md text-timberwolf bg-dark-pastel-green hover:text-mantis duration-200 w-32 text-base p-1">Login</button>
        </div>
        <router-link to="/signup" class="flex text-sm align-middle hover:text-dark-pastel-green duration-200">Do you not have an account? Sign up</router-link>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useUserStore } from '../../stores/UserStore';

const storeUser = new useUserStore()

let email = ref()
let password = ref()

</script>
