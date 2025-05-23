<template>
    <div class="flex flex-col items-center font-semibold justify-center h-[40rem]">
        <h1 class="text-3xl text-center text-timberwolf">Do you really want to logout?</h1>
        <div class="flex flex-row items-center gap-3 p-6 rounded-md">
            <button @click="user.actions.logout()"
                    class="rounded-md text-timberwolf bg-dark-pastel-green hover:text-mantis duration-200 w-32 text-base p-1">
                Yes
            </button>
            <router-link to="/"
                         class="text-center rounded-md text-timberwolf bg-dark-pastel-green hover:text-mantis duration-200 w-32 text-base p-1">
                Go back
            </router-link>
        </div>
    </div>
</template>

<script setup>
import {useUserStore} from '../../stores/UserStore';

const user = useUserStore()
</script>
