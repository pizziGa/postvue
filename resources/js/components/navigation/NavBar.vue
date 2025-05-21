<template>
  <header
    class="flex flex-col w-full text-lg font-mono border-b-2 border-night sticky top-0 start-0"
    x-data="{open: false, search: false}"
  >
    <div class="top-0 w-full min-h-16 bg-nightmare">
      <div
        class="flex md:flex-nowrap md:flex-row flex-col mx-4 h-full md:justify-normal items-center justify-between"
      >
        <div class="flex flex-row justify-between items-center w-full h-16 md:w-auto">
          <button v-if="userLogged.isLoggedIn"
            @click="openSearch"
            class="md:hidden flex items-center justify-center p-3 w-10 h-10 bg-dark-pastel-green text-timberwolf duration-200 rounded"
          >
            <font-awesome-icon :icon="['fa-solid', searchIcon]"></font-awesome-icon>
          </button>

          <div v-else class="md:hidden flex items-center justify-center p-3 w-10 h-10"></div>

          <router-link
            to="/"
            class="duration-200 text-timberwolf hover:text-dark-pastel-green  text-2xl font-extrabold"
            href="/"
          >
            {{ webName }}</router-link
          >

          <button
            @click="openMenu"
            class="md:hidden flex items-center justify-center p-3 w-10 h-10 bg-dark-pastel-green text-timberwolf duration-200 rounded"
          >
            <font-awesome-icon :icon="['fa-solid', menuIcon]"></font-awesome-icon>
          </button>
        </div>

        <!--Search Bar-->
        <div v-if="userLogged.isLoggedIn"
          :class="isSearchBoxOpened ? 'flex' : 'hidden'"
          class="md:flex md:flex-nowrap items-center md:flex-row pb-2 md:pb-0 gap-8 md:w-96 w-full"
        >
          <div class="flex relative md:flex-nowrap w-full md:flex-[unset] md:w-96">
              <input
                v-model="searchQuery"
                class="md:ml-14 md:w-96 w-full p-2 md:p-1 placeholder:font-semibold focus:outline-none bg-nightmare border-b-2 border-r-0 border-dark-pastel-green text-timberwolf placeholder:text-timberwolf font-semibold duration-200"
                type="search"
                placeholder="Search..."
              />
              <button
                form="search_form"
                class="w-14 rounded-r-md duration-200 bg-dark-pastel-green hover:text-mantis text-timberwolf"
              >
                <font-awesome-icon icon="fa-solid fa-search"></font-awesome-icon>
              </button>
          </div>

          <div v-if="searchBoxQuery" class="flex flex-col text-left absolute start-4 md:start-[187.2px] w-[333px] md:w-[286.3px] top-[110px] md:top-[51px] p-5 text-lg bg-night rounded-md rounded-t-none  text-timberwolf">
            <ul v-for="result in results" :key="result.name">
                <li>
                  <router-link :to="'/'+result.name" 
                  class="hover:text-dark-pastel-green duration-200">{{ result.name }}</router-link>
                </li>
            </ul>
          </div>
        </div>

        <!--Navigation Bar-->
        <div v-if="userLogged.isLoggedIn" class="flex flex-row items-center justify-center px-6">
          <nav>
            <ul class="flex flex-row gap-5 font-semibold">
              <li :class="[router.currentRoute.value.name == 'following' ? 'text-dark-pastel-green' : 'text-timberwolf', 'hover:text-dark-pastel-green duration-200']">
                <router-link to="/">Following</router-link>
              </li>
              <li :class="[router.currentRoute.value.name == 'explore' ? 'text-dark-pastel-green' : 'text-timberwolf', 'hover:text-dark-pastel-green duration-200']">
                <router-link to="/explore">Explore</router-link>
              </li>
            </ul>
          </nav>
        </div>

        <div class="flex-1"></div>
        <div class="relative"></div>
          <button
            @click="openMenu"
            class="hidden md:flex items-center focus:ring-2 focus:outline-none focus:ring-mantis  justify-center p-3 w-10 h-10 bg-dark-pastel-green hover:text-mantis duration-200 text-timberwolf rounded"
          >
            <font-awesome-icon v-bind:icon="['fa-solid', menuIcon]"></font-awesome-icon>
          </button>

          <div v-if="isMenuOpened" dir="rtl" class="flex flex-col text-left absolute start-4 top-14 md:top-[55px] p-5 text-lg bg-night rounded-md text-timberwolf">
            <ul>
              <div v-if="userLogged.isLoggedIn" >
                <li>
                  <router-link :to="'/'+userLogged.authName" class="hover:text-dark-pastel-green duration-200"
                    >My profile <font-awesome-icon icon="fa-solid fa-user"></font-awesome-icon
                  ></router-link>
                </li>
                <li>
                  <router-link to="/create" class="hover:text-dark-pastel-green duration-200"
                    >Create <font-awesome-icon icon="fa-solid fa-add"></font-awesome-icon
                  ></router-link>
                </li>
                <li>
                  <router-link to="/logout" class="hover:text-dark-pastel-green duration-200"
                    >Logout <font-awesome-icon icon="fa-solid fa-arrow-right-to-bracket"></font-awesome-icon
                  ></router-link>
                </li>
              </div>
              <div v-else>
                <li>
                  <router-link to="/signup" class="hover:text-dark-pastel-green duration-200"
                    >Register <font-awesome-icon icon="fa-solid fa-user-plus"></font-awesome-icon
                  ></router-link>
                </li>
                <li>
                  <router-link to="/login" class="hover:text-dark-pastel-green duration-200"
                    >Login <font-awesome-icon icon="fa-solid fa-arrow-right-to-bracket"></font-awesome-icon
                  ></router-link>
                </li>
              </div>
            </ul>
          </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { useUserStore } from '@/stores/UserStore';
import router from '@/router'
import debounce from 'lodash.debounce'

const webName = 'InstaVue'
const isMenuOpened = ref(false)
const isSearchBoxOpened = ref(false)

const userLogged = useUserStore()

const searchQuery = ref('')

const searchBoxQuery = ref(false)

const results = ref()

watch(() => searchQuery.value, debounce(() => {
  if (searchQuery.value == '') {
    searchBoxQuery.value = false 
  } else {
    userLogged.actions.searchUser(searchQuery.value)
  .then(data => {
    results.value = data;
    searchBoxQuery.value = true
  })
  .catch(error => { 
    console.log(error)
  })
  }
}, 500))

router.beforeEach(() => {
  searchQuery.value = ''
})

const menuIcon = computed(() => {
  if (isMenuOpened.value) {
    return 'fa-x'
  } else {
    return 'fa-bars'
  }
})

const searchIcon = computed(() => {
  if (isSearchBoxOpened.value) {
    return 'fa-x'
  } else {
    return 'fa-search'
  }
})

function openMenu() {
  isMenuOpened.value = !isMenuOpened.value
}

function openSearch() {
  isSearchBoxOpened.value = !isSearchBoxOpened.value
}

</script>
