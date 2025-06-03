<template>
    <div class="md:w-150 p-2">
        <div class="flex flex-col bg-abysm font-semibold rounded-2xl shadow-2xl shadow-eerie-black">
            <div class="flex flex-row align-middle">
                <router-link :to="'/'+post.author"
                             class="text-lg pt-2 px-4 text-white hover:text-screamin-green">{{ post.author }}
                </router-link>
                <div class="flex-1"></div>
                <button v-if="post.authorized" @click="deletePost()"
                        class="flex align-middle items-center px-3 text-lg text-white hover:text-red-600 duration-200 cursor-pointer">
                    <font-awesome-icon icon="fa-regular fa-trash-can"></font-awesome-icon>
                </button>
            </div>

            <div class="flex justify-center items-center bg-abysm">
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
                <comment-section v-else :post_id="post.id"></comment-section>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, computed, defineProps, defineEmits} from 'vue'
import {useUserStore} from '../../stores/UserStore';
import {usePostStore} from "../../stores/PostStore.js";
import CommentSection from "./CommentSection.vue";

const userStore = useUserStore()
const postStore = usePostStore()

const emit = defineEmits(['delete'])

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
])

const isLiked = ref(post.isLiked)

let likes = ref(post.likes)

function likePost() {
    isLiked.value = !isLiked.value
    isLiked.value ? likes.value++ : likes.value--
    postStore.actions.likePost(post.id, isLiked.value)
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

function deletePost() {
    postStore.actions.deletePost(post.id)
    emit('delete')
}

</script>
