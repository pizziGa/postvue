<template>
    <div class="flex flex-col items-center font-semibold justify-center h-[40rem] text-white">
        <h1 class="text-3xl">Login</h1>
        <div class="flex flex-col items-center text-lg gap-3 p-6 rounded-md">
            <input type="text" v-model="email" placeholder="Email"
                   class="border-b-2 border-eerie-black w-80 md:h-12 h-16 duration-200 focus:border-screamin-green hover:border-screamin-green bg-nightmare focus:outline-none placeholder:font-semibold md:placeholder:text-lg placeholder:text-2xl md:text-lg text-2xl placeholder:text-white text-white p-1">
            <input type="password" v-model="password" placeholder="Password"
                   class="border-b-2 w-80 md:h-12 h-16 border-eerie-black duration-200 focus:border-screamin-green hover:border-screamin-green bg-nightmare focus:outline-none placeholder:font-semibold md:placeholder:text-lg placeholder:text-2xl md:text-lg text-2xl placeholder:text-white text-white p-1">
            <button @click="storeUser.actions.authenticate(email, password)"
                    class="flex items-center justify-center text-center md:text-base text-xl p-2 gap-2 text-white hover:bg-eerie-black bg-night duration-200 rounded-md w-18">
                Login
            </button>
        </div>
        <div class="flex flex-row gap-1">
            Do you not have an account?<router-link to="/signup" class="duration-200 flex align-middle underline hover:text-screamin-green">Sign up</router-link>
        </div>

    </div>
</template>

<script setup>
import {ref} from 'vue'
import {useUserStore} from '../../stores/UserStore';

const storeUser = new useUserStore()

let email = ref()
let password = ref()

</script>
