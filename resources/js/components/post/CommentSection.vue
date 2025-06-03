<script setup>
import {ref, onMounted} from "vue";
import {useCommentStore} from "../../stores/CommentStore.js";
import CommentComponent from "./CommentComponent.vue";

const prop = defineProps(['post_id'])
const commentStore = useCommentStore()
const newComment = ref()
const comments = ref()

onMounted(() => {
    fetchComments()
})

function fetchComments() {
    commentStore.actions.fetchPostComments(prop.post_id)
    .then(data => {
        comments.value = data
        console.log(data)
    })
    .catch(error => {
        console.log(error)
    })
}

function uploadNewComment() {
    commentStore.actions.uploadComment(prop.post_id, newComment.value)
    .then(() => {
        fetchComments()
        newComment.value = ''
    })
}
</script>

<template>
    <div class="flex flex-col font-semibold w-full h-full bg-abysm rounded-b-2xl">
        <div class="h-full overflow-scroll overflow-x-hidden">
            <comment-component v-for="comment in comments" :key="comment.content" :author="comment.author.name"
                               :content="comment.comment"/>
        </div>
        <div class="flex flex-row flex-nowrap m-2 gap-3">
            <input type="text" v-model="newComment" placeholder="Comment..."
                   class="w-[85%] p-2 rounded-2xl border-abysm placeholder:text-white focus:bg-eerie-black placeholder:opacity-45
                          duration-200 focus:outline-none text-white bg-night hover:bg-eerie-black">
            <button @click="uploadNewComment()"
                    class="p-2 w-[25%] rounded-2xl text-white bg-night hover:bg-eerie-black duration-200">
                <font-awesome-icon icon="fa-solid fa-arrow-right"></font-awesome-icon>
            </button>
        </div>
    </div>
</template>

