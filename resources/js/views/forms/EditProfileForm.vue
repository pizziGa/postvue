<template>
    <div class="flex flex-col items-center font-semibold justify-center h-[40rem] text-white">
        <h1 class="text-3xl">Edit your profile</h1>
        <div class="flex flex-col items-center gap-3 p-6 rounded-md">
            <input type="file" ref="file" class="border-b-2 w-80 md:h-12 h-16 duration-200 focus:border-screamin-green hover:border-screamin-green focus:outline-none border-eerie-black bg-nightmare placeholder:font-semibold placeholder:text-lg p-1" name="img_path">
            <input type="text" class="border-b-2 w-80 md:h-12 h-16 border-eerie-black duration-200 focus:border-screamin-green hover:border-screamin-green bg-nightmare focus:outline-none placeholder:font-semibold md:placeholder:text-lg placeholder:text-2xl md:text-lg text-2xl placeholder:text-white text-white p-1" placeholder="Username" v-model="name">
            <textarea class="border-b-2 w-80 md:h-12 h-16 border-eerie-black duration-200 bg-nightmare focus:border-screamin-green hover:border-screamin-green placeholder:font-semibold focus:outline-none md:placeholder:text-lg placeholder:text-2xl md:text-lg text-2xl placeholder:text-white text-white p-1" placeholder="Biography" v-model="biography"></textarea>
            <button @click="user.actions.update(file.files[0], name, biography)" class="flex items-center justify-center text-center md:text-base text-xl p-2 gap-2 text-white hover:bg-eerie-black bg-night duration-200 rounded-md w-18">Edit</button>
        </div>
    </div>
</template>

<script setup>
import { ref, onBeforeMount } from 'vue'
import { useUserStore } from '@/stores/UserStore';
import router from '@/router'

const user = useUserStore()

const prop = router.currentRoute.value.params.username

const file = ref()
const name = ref()
const biography = ref()

onBeforeMount(async () => {
    const data = await user.actions.fetchUser(prop)
    name.value = data.user.name
    biography.value = data.user.bio
})

</script>
