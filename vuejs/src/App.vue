<script setup>
import NavBar from '@/components/navigation/NavBar.vue';
import FooterBar from '@/components/navigation/FooterBar.vue';
</script>

<template>
  <nav-bar/>

  <main class="flex justify-center flex-1 min-h-[calc(100vh-4rem)] font-mono pattern bg-primary-white select-none">
    <router-view/>
  </main>
  
  <footer-bar/>
</template>

<style>
.pattern {
  opacity: 1;
  background-image:  radial-gradient(#ded15e 1px, transparent 1px), radial-gradient(#ded15e 1px, #ffffff 1px);
  background-size: 40px 40px;
  background-position: 0 0,20px 20px;
}
</style>
