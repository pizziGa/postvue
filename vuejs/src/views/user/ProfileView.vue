<template>
    <div class="flex flex-col w-full">
        <div class="flex flex-col items-center justify-center gap-2 p-3 font-semibold">
            <div class="flex items-center justify-center rounded-full border-4 border-amber-400 shadow-sm shadow-secondary-black">
                <img v-if="user.pfp" :src="'/pfp.jpg'" class="w-28 h-28 rounded-full">
                <img v-else :src="'/default.jpg'" class="w-28 h-28 rounded-full">
            </div>
            
            <div class="flex flex-col items-center text-primary-black justify-center">
                <h1 class="text-2xl">{{ user.name }}</h1>
                <div class="flex flex-row items-center text-primary-black justify-center gap-4">
                    <p class="text-base">{{ user.followers }} followers</p>
                    <p class="text-base">{{ user.following }} following</p>
                </div>
                
                <p v-if="user.bio" class="text-center w-full text-sm md:w-1/2 font-normal">{{ user.bio }}</p>
                <p v-else class="text-center w-full text-sm md:w-1/2 font-normal">There isn't a bio here yet. Let's start writing one!</p>
            </div>
            <div class="flex flex-row justify-center gap-3 p-2">
                <button class="flex items-center justify-center text-center text-xl p-2 gap-2 bg-amber-400 hover:bg-amber-500 duration-200 shadow-sm shadow-secondary-black border-2 border-primary-black rounded-md h-10">
                    <router-link to="/edit">Edit <font-awesome-icon icon="fa-solid fa-pen"></font-awesome-icon></router-link>
                </button>
                <button @click="followUser" class="flex items-center justify-center text-center text-xl p-2 gap-2 bg-amber-400 hover:bg-amber-500 duration-200 shadow-sm shadow-secondary-black border-2 border-primary-black rounded-md h-10">
                    <h1 v-if="!isFollowed">Follow</h1><h1 v-else>Unfollow</h1>
                    <font-awesome-icon :icon="['fa-solid', userFollowed]"></font-awesome-icon>
                </button>
            </div>
            <hr class="md:w-2/5 w-4/5 h-[0.1rem] bg-gray-600 rounded-full">
        </div>
        <div class="flex flex-col gap-3 items-center justify-center">
            <post-component/>
            <post-component/>
            <!--<h1 class="text-xl p-5 font-semibold">There aren't posts here yet</h1>-->
        </div>
    </div>
</template>

<script setup>
import PostComponent from '../../components/post/PostComponent.vue';
import { ref, computed, reactive, onMounted } from 'vue'
import axios from 'axios'

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

const isFollowed = ref(false)

const user = reactive({
    name: '',
    pfp: '',
    followers: 0,
    following: 0,
    bio: ''
})

const userFollowed = computed(() => {
    if (!isFollowed.value) {
        return 'fa-user-plus';
    } else {
        return 'fa-user-minus';
    }
})

function followUser() {
    isFollowed.value = !isFollowed.value;
    if (isFollowed.value) {
        user.followers += 1;
    } else {
        user.followers -= 1;
    }
}

onMounted(async () => {
    await axios.get('http://localhost:8000/sanctum/csrf-cookie')
    const data = await axios.get('http://localhost:8000/api/user');
    user.name = data.data.user.name;
    user.bio = data.data.user.bio;
    user.pfp = data.data.user.pfp;
})
</script>
