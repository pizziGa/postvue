<template>
    <div class="flex flex-col items-center font-semibold justify-center h-[40rem]">
        <h1 class="text-3xl text-timberwolf">Edit your profile</h1>
        <div class="flex flex-col items-center gap-3 p-6 rounded-md">
            <input type="file" ref="file" @change="handleFileUpload()" class="border-b-2 w-80 h-12 border-dark-pastel-green bg-nightmare placeholder:font-semibold placeholder:text-lg placeholder:text-timberwolf p-1" name="img_path">
            <input type="text" class="border-b-2 w-80 h-12 border-dark-pastel-green bg-nightmare placeholder:font-semibold placeholder:text-lg placeholder:text-timberwolf text-timberwolf p-1" placeholder="Username" v-model="name">
            <textarea class="border-b-2 w-80 h-12 border-dark-pastel-green bg-nightmare placeholder:font-semibold placeholder:text-lg placeholder:text-timberwolf text-timberwolf p-1" placeholder="Biography" v-model="biography"></textarea>
            <button @click="user.actions.update(file.files[0], name, biography)" class="rounded-md text-timberwolf bg-dark-pastel-green hover:text-mantis duration-200 w-32 text-base p-1">Edit</button>
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

const handleFileUpload = async () => {
    console.log("selected file",file.value.files)
}

onBeforeMount(async () => {
    const data = await user.actions.fetchUser(prop)
    name.value = data.user.name
    biography.value = data.user.bio
})

</script>