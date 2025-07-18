<template>
    <div class="flex flex-col w-full">
        <div class="flex flex-col items-center justify-center">
            <div class="flex flex-col items-center justify-center gap-5 p-3">
                <div class="flex items-center justify-center rounded-full border-3 border-screamin-green shadow-sm shadow-nightmare">
                    <img v-if="user.pfp != undefined" :src="user.pfp" class="w-20 h-20 rounded-full">
                    <img v-else src="../../../assets/default.jpg" class="w-20 h-20 rounded-full">
                </div>

                <div class="flex flex-col text-white items-center justify-center">
                    <h1 class="text-2xl select-none">{{ user.name }}</h1>
                    <div class="flex flex-row items-center justify-center gap-4 text-white select-none">
                        <p class="text-base">{{ user.followers }} followers</p>
                        <p class="text-base">{{ user.following }} following</p>
                    </div>

                    <p v-if="user.bio != undefined" class="w-full text-sm md:w-1/2 font-normal text-center select-none">{{ user.bio }}</p>
                    <p v-else class="text-center w-full text-sm md:w-1/2 font-normal">There isn't a bio here yet. Let's start writing one!</p>
                </div>
            </div>
            <div class="flex flex-row justify-center gap-3 p-1">
                <button v-if="isAuth" class="flex items-center justify-center text-center md:text-sm text-xl p-2 gap-2 text-white hover:bg-eerie-black bg-night duration-200 rounded-md">
                    <router-link :to="prop+'/edit'">Edit <font-awesome-icon icon="fa-solid fa-pen"></font-awesome-icon></router-link>
                </button>
                <button v-else @click="followUser" class="flex items-center justify-center text-center md:text-sm text-xl p-2 gap-2 text-white bg-night hover:bg-screamin-green duration-200 rounded-md h-10">
                    <h1 v-if="!isFollowed">Follow</h1><h1 v-else>Unfollow</h1>
                    <font-awesome-icon :icon="['fa-solid', userFollowed]"></font-awesome-icon>
                </button>
                <button v-if="isAuth" @click="copyToClipboard()" class="flex items-center justify-center text-center md:text-sm text-xl p-2 gap-2 text-white hover:bg-eerie-black bg-night  duration-200 rounded-md">
                    Share <font-awesome-icon icon="fa-solid fa-share-nodes"></font-awesome-icon>
                </button>
            </div>
        </div>

        <div class="flex flex-col gap-3 items-center justify-center">
            <post-component v-for="post in posts" :key="post.id"  :id="post.post_id" :media="post.media" :mediaType="post.type"
            :content="post.content" :likes="post.likes" :isLiked="post.isLiked" :authorized="isAuth"
            :author="post.author.name" @delete="fetchUserPosts"/>
        </div>
    </div>
</template>

<script setup>
import PostComponent from '../../components/post/PostComponent.vue';
import { ref, computed, reactive, onBeforeMount } from 'vue'
import { useUserStore } from '../../stores/UserStore';
import router from '@/router'
import {usePostStore} from "../../stores/PostStore.js";

const userStore = useUserStore()
const postStore = usePostStore()

const isFollowed = ref(false)

const prop = router.currentRoute.value.params.username

const user = reactive({
    name: '',
    bio: undefined,
    pfp: undefined,
    followers: 0,
    following: 0
});

const posts = ref()

const pfp_url = ref()

const isAuth = ref()

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
        userStore.actions.followUser(prop)
    } else {
        user.followers -= 1;
        userStore.actions.unfollowUser(prop)
    }
}

function fetchUserData() {
    userStore.actions.fetchUser(prop)
    .then(data => {
        user.name = data.user.name
        user.bio = data.user.bio
        user.pfp = data.user.pfp
        user.followers = data.user.followers
        user.following = data.user.following
        isAuth.value = data.isAuth
        isFollowed.value = data.isFollowed
        pfp_url.value = '/api/user/' + user.pfp
    })
    .catch(error => {
        console.log(error)
    })
}

function fetchUserPosts() {
    postStore.actions.fetchUserPost(prop)
    .then(data => {
        posts.value = data
    })
    .catch(error => {
        console.log(error)
    })
}

function copyToClipboard() {
    const path = window.location.origin + router.currentRoute.value.path
    navigator.clipboard.writeText(path);
    alert('Link copied to clipboard!');
}

onBeforeMount(() => {
    fetchUserData()
    fetchUserPosts()
})
</script>
