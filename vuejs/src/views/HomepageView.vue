<template>
    <div class="flex flex-col w-full justify-center items-center">
        <post-component/>
        <post-component/>
    </div>
</template>

<script setup>
import PostComponent from '../components/post/PostComponent.vue';
import { ref, onMounted } from 'vue'
import axios from 'axios'

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

onMounted(async () => {
    
})
</script>