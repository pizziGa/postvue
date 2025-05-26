<template>
    <div class="md:w-150  p-2">
        <div class="flex flex-col bg-night font-semibold rounded-2xl">
            <div class="flex flex-row align-middle">
                <router-link :to="'/'+post.author"
                             class="text-lg pt-2 px-4 text-white hover:text-screamin-green">{{ post.author }}
                </router-link>
                <div class="flex-1"></div>
                <button v-if="post.authorized" @click="userStore.actions.deletePost(post.id)"
                        class="flex align-middle items-center px-3 text-lg text-white hover:text-red-600 duration-200">
                    <font-awesome-icon icon="fa-regular fa-trash-can"></font-awesome-icon>
                </button>
            </div>

            <div class="flex justify-center items-center border-b-2 border-t-2 border-nightmare bg-night">
                <img v-if="post.mediaType === 'image'" alt="image" :src="media"/>
                <video v-else :src="media" controls
                       controlslist="nofullscreen nodownload noremoteplayback noplaybackrate foobar"></video>
            </div>

            <div class="flex flex-row p-2 px-4 text-3xl gap-4">
                <button @click="likePost" class="flex flex-row items-center">
                    <font-awesome-icon :icon="[likeIconPressed, 'fa-heart']"
                                       :class="['hover:text-red-700 duration-200', likeColorPressed]"></font-awesome-icon>
                    <span class="text-base text-white">:{{ likes }}</span>
                </button>
                <button @click="openComments">
                    <font-awesome-icon :icon="[commentsIconPressed, 'fa-comment']"
                                       :class="['hover:text-screamin-green duration-200', commentColorPressed]"></font-awesome-icon>
                </button>
            </div>

            <div class="h-[20vh]">
                <div v-if="!isCommentOpened" class="h-full overflow-scroll overflow-x-hidden text-white">
                    <p class="p-2">{{ post.content }}</p>
                </div>

                <div v-else class="flex flex-col font-semibold w-full h-full bg-night rounded-b-2xl">
                    <div class="h-full overflow-scroll overflow-x-hidden">
                        <div v-for="comment in comments" :key="comment.content">
                            <comment-component :author="comment.author.name" :content="comment.comment"/>
                        </div>
                    </div>
                    <div class="flex flex-row flex-nowrap border-t-2 border-nightmare border-0">
                        <input type="text" v-model="comment" placeholder="Comment..."
                               class="w-[85%] p-2 rounded-bl-2xl border-abysm border-r-2 placeholder:text-white focus:bg-eerie-black placeholder:opacity-45 duration-200 focus:outline-none text-white bg-night hover:bg-eerie-black">
                        <button @click="userStore.actions.uploadComment(post.id, comment)"
                                class="p-2 w-[25%] rounded-br-2xl text-white bg-night hover:bg-eerie-black  duration-200">
                            <font-awesome-icon icon="fa-solid fa-arrow-right"></font-awesome-icon>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import CommentComponent from './CommentComponent.vue'
import {ref, computed, defineProps} from 'vue'
import {useUserStore} from '@/stores/UserStore';

const userStore = useUserStore()

const isCommentOpened = ref(false)

const post = defineProps([
    'id',
    'media',
    'likes',
    'content',
    'isLiked',
    'mediaType',
    'authorized',
    'author',
    'comments'
])

const isLiked = ref(post.isLiked)

let likes = ref(post.likes)

const comments = ref(post.comments)

//const media_url = '/api/post/' + post.media

const comment = ref()

function likePost() {
    isLiked.value = !isLiked.value
    isLiked.value ? likes.value++ : likes.value--
    userStore.actions.likePost(post.id, isLiked.value)
}

function openComments() {
    isCommentOpened.value = !isCommentOpened.value;
}

const likeIconPressed = computed(() => {
    if (isLiked.value) {
        return 'fa-solid'
    } else {
        return 'fa-regular'
    }
})

const likeColorPressed = computed(() => {
    if (isLiked.value) {
        return 'text-red-600'
    } else {
        return 'text-white'
    }
})

const commentColorPressed = computed(() => {
    if (isCommentOpened.value) {
        return 'text-screamin-green'
    } else {
        return 'text-white'
    }
})

const commentsIconPressed = computed(() => {
    if (isCommentOpened.value) {
        return 'fa-solid'
    } else {
        return 'fa-regular'
    }
})

</script>
