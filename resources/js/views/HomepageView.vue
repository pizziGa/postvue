<template>
    <div class="flex flex-col w-full">
        <div v-for="post in posts" :key="post.id" class="flex flex-col gap-3 items-center justify-center">
            <post-component :id="post.post_id" :media="post.media" :mediaType="post.type"
            :content="post.content" :likes="post.likes" :isLiked="post.isLiked"
            :authorized="false" :author="post.author.name" :comments="post.comments"/>
        </div>

        <!--<h1 v-if="!home.isExplore" class="flex flex-col gap-3 items-center h-full text-center text-timberwolf text-2xl font-bold justify-center">There aren't any posts here. Let's start following someone!</h1>-->
    </div>
</template>

<script setup>
import PostComponent from '../components/post/PostComponent.vue';
import { ref, onBeforeMount } from 'vue'
import { useUserStore } from '@/stores/UserStore';
import router from '@/router';

const userStore = useUserStore()

const posts = ref()

onBeforeMount(() => {
    if (router.currentRoute.value.name === 'explore') {
        userStore.actions.fetchExplorePosts()
        .then(data => {
            posts.value = data
        })
        .catch(error => {
            console.log(error)
        })
    } else {
        userStore.actions.fetchFollowingPosts()
        .then(data => {
            posts.value = data
        })
        .catch(error => {
            console.log(error)
        })
    }
})
</script>
