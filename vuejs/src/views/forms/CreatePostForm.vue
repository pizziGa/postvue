<template>
    <div class="flex flex-col items-center font-semibold justify-center h-[40rem]">
        <h1 class="text-3xl text-timberwolf">Create a post</h1>
        <div class="flex flex-col items-center gap-3 p-6 rounded-md">
            <input type="file" ref="file" @change="handleFileUpload()" class="border-b-2 w-80 h-12 border-dark-pastel-green bg-nightmare placeholder:font-semibold placeholder:text-lg placeholder:text-timberwolf p-1" name="img_path">
            <textarea class="border-b-2 w-80 h-12 border-dark-pastel-green bg-nightmare placeholder:font-semibold placeholder:text-lg placeholder:text-timberwolf text-timberwolf p-1" placeholder="Content..." v-model="content"></textarea>
            <button @click="user.actions.upload(file.files[0], content)" class="rounded-md text-timberwolf bg-dark-pastel-green hover:text-mantis duration-200 w-32 text-base p-1">Create</button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useUserStore } from '@/stores/UserStore';

const user = useUserStore()

const file = ref()
const content = ref()

const handleFileUpload = async () => {
    console.log("selected file",file.value.files)
}
</script>
