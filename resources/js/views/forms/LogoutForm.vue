<template>
    <div class="flex flex-col items-center font-semibold justify-center h-[40rem]">
        <h1 class="text-3xl text-center text-white">Do you really want to logout?</h1>
        <div class="flex flex-row items-center gap-3 p-6 rounded-md">
            <button @click="user.actions.logout()"
                    class="flex items-center justify-center text-center md:text-base text-xl p-2 gap-2 text-white hover:bg-eerie-black bg-night duration-200 rounded-md w-24">
                Yes
            </button>
            <router-link to="/"
                         class="flex items-center justify-center text-center md:text-base text-xl p-2 gap-2 text-white hover:bg-eerie-black bg-night duration-200 rounded-md w-24">
                Go back
            </router-link>
        </div>
    </div>
</template>

<script setup>
import {useUserStore} from '../../stores/UserStore';

const user = useUserStore()
</script>
