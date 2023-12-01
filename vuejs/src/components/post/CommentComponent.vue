<template>
    <h4 class="text-base pt-2 px-2">{{ author }}</h4>
    <p class="text-sm px-4">{{ content }}</p>
</template>

<script>
export default {
    name: 'CommentComponent',
    props: {
        author: {
            type: String,
            required: true
        },
        content: {
            type: String,
            required: true
        }
    }
}
</script>