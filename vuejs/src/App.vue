<script setup>
import { ref, watch } from 'vue';
import NavBar from '@/components/navigation/NavBar.vue'
import FooterBar from '@/components/navigation/FooterBar.vue'
import router from '@/router'

const section = ref()

watch(() => router.currentRoute.value.name, (val) => {
  section.value = val
})
</script>

<template>
  <nav-bar :selected="section"/>

  <main class="flex justify-center flex-1 min-h-[calc(100vh-4rem)] font-mono bg-nightmare">
    <Suspense>
      <router-view v-slot="{ Component }">
        <Suspense>
          <template #default>
            <component :is="Component" :key="$route.path"></component>
          </template>
          <template #fallback>
            <div>Loading...</div>
          </template>
        </Suspense>
     </router-view>
    </Suspense>
  </main>

  <footer-bar />
</template>

