<template>
    <div class="md:w-1/4 p-2">
        <div class="flex flex-col bg-primary-white font-semibold rounded-md border-2 border-primary-black shadow-sm shadow-secondary-black">
            <div class="flex flex-row align-middle ">
                <h4 class="text-lg pt-2 px-4">{{ post.author }}</h4>
                <div class="flex-1"></div>
                <form action="" id="delete_form" method="post"></form>
                <button form="delete_form" type="submit" class="flex align-middle items-center px-3 text-lg text-red-500 hover:text-red-600 duration-200">
                    <font-awesome-icon icon="fa-regular fa-trash-can"></font-awesome-icon>
                </button>
            </div>

            <div class="flex justify-center items-center border-b-2 border-t-2 border-primary-black bg-primary-black"><img src="/img.jpg"/></div>
    
            <div class="flex flex-row p-2 px-4 text-3xl gap-4">
                <button @click="likePost" class="flex flex-row items-center">
                    <font-awesome-icon :icon="[likeIconPressed, 'fa-heart']" :class="['hover:text-red-700 duration-200', likeColorPressed]"></font-awesome-icon>
                    <p class="text-sm">:{{ post.likes }}</p>
                </button>
                <button @click="openComments">
                    <font-awesome-icon :icon="[commentsIconPressed, 'fa-comment']" :class="['hover:text-amber-500 duration-200', commentColorPressed]"></font-awesome-icon>
                </button>
            </div>

            <div class="h-[25vh] shadow-sm shadow-secondary-black">
                <div v-if="!isCommentOpened" class="h-full overflow-scroll overflow-x-hidden">
                    <p class="p-2">{{ post.description }}</p>
                </div>
                
                <div v-else class="flex flex-col font-semibold w-full h-full bg-primary-white rounded-b-md">
                    <div class="h-full overflow-scroll overflow-x-hidden">
                        <div v-for="comment in post.comments" :key="comment.content">
                            <comment-component :author="comment.author" :content="comment.content"/>
                        </div>
                    </div>  
                    <div class="flex flex-row flex-nowrap border-t-2 border-primary-black border-0">
                        <input type="text" placeholder="Comment..." class="w-[85%] p-2 rounded-bl-md bg-primary-white">
                        <button class="p-2 w-[25%] border-l-2 rounded-br-md border-primary-black bg-amber-400 hover:bg-amber-500">
                            <font-awesome-icon icon="fa-solid fa-arrow-right"></font-awesome-icon >
                        </button>
                    </div>
                </div>
            </div>
            
        </div>  
    </div>  
</template>

<script setup>
import CommentComponent from './CommentComponent.vue'
import { ref, reactive, computed } from 'vue'

const isLiked = ref(false)

const isCommentOpened = ref(false)

const post = reactive({
    author: 'Giorgino',
    likes: 0,
    description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    comments: [
        {
            author: 'Gianni Fantoni',
            content: 'ayo'
        },
        {
            author: 'Adondekayon',
            content: 'stfu'
        },
        {
            author: 'Primadonna Johnny',
            content: 'ciao'
        },
        {
            author: 'Paolo',
            content: 'esplodo'
        },
        {
            author: 'Mussolini',
            content: 'ITALIANI'
        }
    ]
})

function likePost() {
    isLiked.value = !isLiked.value;
    if (isLiked.value) {
        post.likes++;
    } else {
        post.likes--;
    }
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
        return 'text-primary-black'
    }
}) 

const commentColorPressed = computed(() => {
    if (isCommentOpened.value) {
        return 'text-amber-500'
    } else {
        return 'text-primary-black'
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
