<script setup>
import NavBar from './components/navigation/NavBar.vue'
import FooterBar from './components/navigation/FooterBar.vue'
</script>

<template>
  <nav-bar/>

  <main class="flex justify-center flex-1 min-h-screen bg-nightmare">
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