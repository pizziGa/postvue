<template>
    <div class="flex flex-col items-center font-semibold justify-center h-[40rem]">
        <h1 class="text-2xl">Edit your profile</h1>
        <div class="flex flex-col items-center gap-3 p-6 rounded-md">
            <input type="file" ref="file" @change="handleFileUpload()" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-base p-1" name="img_path">
            <input type="text" class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-12 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-lg p-1" placeholder="Username" v-model="name">
            <textarea class="rounded-md border-2 shadow-sm shadow-secondary-black w-80 h-28 border-primary-black bg-primary-white placeholder:font-semibold placeholder:text-base p-1" placeholder="Biography" v-model="biography"></textarea>
            <button @click="user.actions.update(file, name, biography)" class="rounded-md border-2 shadow-sm shadow-secondary-black border-primary-black  bg-amber-400 hover:bg-amber-500 duration-200 w-32 text-base p-1">Edit</button>
        </div>
    </div>
</template>

<script setup>
import { ref, onBeforeMount } from 'vue'
import { useUserStore } from '../../stores/UserStore';

const user = useUserStore()

const file = ref()
const name = ref()
const biography = ref()

const handleFileUpload = async () => {
    console.log("selected file",file.value.files)
}

onBeforeMount(async () => {
    const data = await user.actions.fetchUser()
    name.value = data.name
    biography.value = data.bio
})

</script>