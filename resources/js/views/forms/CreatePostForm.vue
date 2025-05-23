<template>
    <div class="flex flex-col items-center font-semibold justify-center h-[40rem] text-white">
        <h1 class="text-3xl">Create a post</h1>
        <div class="flex flex-col items-center gap-3 p-6 rounded-md ">
            <input type="file" ref="file"
                   class="border-b-2 w-80 h-12 border-eerie-black duration-200 focus:border-screamin-green hover:border-screamin-green bg-nightmare focus:outline-none placeholder:font-semibold placeholder:text-lg placeholder:text-white placeholder:opacity-40 text-white p-1"
                   name="img_path">
            <textarea
                class="border-b-2 w-80 h-12 border-eerie-black duration-200 focus:border-screamin-green hover:border-screamin-green bg-nightmare focus:outline-none placeholder:font-semibold placeholder:text-lg placeholder:text-white text-white p-1"
                placeholder="Content..." v-model="content"></textarea>
            <button @click="user.actions.upload(file.files[0], content)"
                    class="flex items-center justify-center text-center text-base p-2 gap-2 text-white hover:bg-eerie-black bg-night duration-200 rounded-md w-18">
                Create
            </button>
        </div>
    </div>
</template>

<script setup>
import {ref} from 'vue'
import {useUserStore} from '@/stores/UserStore';

const user = useUserStore()

const file = ref()
const content = ref()
</script>
