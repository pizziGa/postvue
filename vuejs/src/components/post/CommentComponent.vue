<template>
    <h4 class="text-base pt-2 px-2">{{ props.author }}</h4>
    <p class="text-sm px-4">{{ props.content }}</p>
</template>

<script setup>
const props = defineProps({
    author: {
        type: String,
        required: true
    },
    content: {
        type: String,
        required: true
    }
})
</script>