<template>
    <div class="flex flex-col items-center font-semibold justify-center h-[40rem]">
        <h1 class="text-xl">Do you really want to logout?</h1>
        <div class="flex flex-row items-center gap-3 p-6 rounded-md">
            <button @click="logout" class="rounded-md border-2 cursor-pointer shadow-sm shadow-secondary-black border-primary-black  bg-amber-400 hover:bg-amber-500 duration-200 w-32 text-base p-1">Yes</button>
            <router-link to="/" class="text-center rounded-md border-2 cursor-pointer shadow-sm shadow-secondary-black border-primary-black  bg-amber-400 hover:bg-amber-500 duration-200 w-32 text-base p-1">Go back</router-link>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios'
import router from '@/router'

axios.defaults.withCredentials = true
axios.defaults.withXSRFToken = true

async function logout() {
    await axios.post('http://localhost:8000/api/user/logout');
}
</script>