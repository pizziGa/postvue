<template>
    <div class="flex flex-col w-full justify-center items-center">
        <post-component/>
        <post-component/>
    </div>
</template>

<script>
import PostComponent from '../components/post/PostComponent.vue';
export default {
    name: 'HomepageView',
    components: {
        PostComponent
    }
}
</script>