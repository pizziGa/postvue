<template>
    <header class="flex flex-col w-full text-lg sticky top-0 start-0">
        <div class="top-0 w-full min-h-16 bg-abysm">
            <div
                class="flex md:flex-nowrap md:flex-row flex-col mx-4 h-full md:justify-normal items-center justify-between">
                <div class="flex flex-row justify-between items-center w-full h-16 md:w-auto">
                    <button v-if="userLogged.isLoggedIn" @click="openSearch"
                            class="md:hidden focus:rounded-3xl focus:bg-eerie-black flex items-center justify-center p-3 w-10 h-10 focus:text-screamin-green text-white duration-200 rounded">
                        <font-awesome-icon :icon="['fa-solid', searchIcon]"></font-awesome-icon>
                    </button>

                    <div v-else class="md:hidden flex items-center justify-center p-3 w-10 h-10"></div>

                    <router-link
                        to="/"
                        class="duration-200 text-white flex flex-col justify-center text-center"
                        href="/"
                    >
                        <div class="font-semibold text-3xl">
                            Post<span class="text-screamin-green">Vue</span>
                        </div>

                        <div class="text-xs">DEMO</div>
                    </router-link>

                    <button
                        @click="openMenu"
                        class="md:hidden flex focus:rounded-3xl focus:bg-eerie-black items-center justify-center p-3 w-10 h-10 focus:text-screamin-green text-white duration-200 rounded"
                    >
                        <font-awesome-icon :icon="['fa-solid', menuIcon]"></font-awesome-icon>
                    </button>
                </div>

                <!--Search Bar-->
                <div v-if="userLogged.isLoggedIn"
                     :class="isSearchBoxOpened ? 'flex' : 'hidden'"
                     class="md:flex md:flex-nowrap items-center md:flex-row pb-2 md:pb-0 gap-8 md:w-96 w-full"
                >
                    <div class="flex relative w-full md:w-96">
                        <input
                            v-model="searchQuery"
                            :class="searchBoxQuery ? 'rounded-b-none' : ''"
                            class="md:ml-14 w-full p-[5px] focus:outline-none bg-night rounded rounded-2xl text-white placeholder:text-white placeholder:opacity-45 focus:bg-eerie-black hover:bg-eerie-black"
                            type="search"
                            placeholder="Search..."
                        />
                    </div>

                    <ul v-for="result in results" :key="result.name" v-if="searchBoxQuery"
                        class="flex flex-col text-left absolute rounded-t-none start-4 md:left-50 top-[100px] md:w-82 md:top-[50px] p-5 text-lg bg-night rounded-md text-white">
                        <li class="w-[60vh] md:w-96">
                            <router-link :to="'/'+result.name"
                                         class="hover:text-screamin-green duration-200">{{ result.name }}
                            </router-link>
                        </li>
                    </ul>
                </div>

                <!--Navigation Bar-->
                <div v-if="userLogged.isLoggedIn" class="flex flex-row items-center justify-center px-6">
                    <nav>
                        <ul class="flex flex-row gap-5 font-semibold">
                            <li :class="[router.currentRoute.value.name === 'following' ? 'text-screamin-green' : 'text-white', 'hover:text-screamin-green duration-200']">
                                <router-link to="/">Following</router-link>
                            </li>
                            <li :class="[router.currentRoute.value.name === 'explore' ? 'text-screamin-green' : 'text-white', 'hover:text-screamin-green duration-200']">
                                <router-link to="/explore">Explore</router-link>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="flex-1"></div>
                <div class="relative"></div>
                <button
                    @click="openMenu"
                    class="hidden md:flex items-center hover:rounded-3xl hover:bg-eerie-black focus:outline-none justify-center p-3 w-10 h-10 hover:text-screamin-green duration-200 text-white rounded"
                >
                    <font-awesome-icon v-bind:icon="['fa-solid', menuIcon]"></font-awesome-icon>
                </button>

                <div v-if="isMenuOpened" dir="rtl"
                     class="flex flex-col text-left absolute start-4 top-14 md:top-[55px] p-5 text-lg bg-night rounded-md text-white">
                    <ul v-if="userLogged.isLoggedIn">
                        <li>
                            <router-link :to="'/'+userLogged.authName" class="hover:text-screamin-green duration-200"
                            >My profile
                                <font-awesome-icon icon="fa-solid fa-user"></font-awesome-icon
                                >
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/create" class="hover:text-screamin-green duration-200"
                            >Create
                                <font-awesome-icon icon="fa-solid fa-add"></font-awesome-icon
                                >
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/logout" class="hover:text-screamin-green duration-200"
                            >Logout
                                <font-awesome-icon icon="fa-solid fa-arrow-right-to-bracket"></font-awesome-icon
                                >
                            </router-link>
                        </li>
                    </ul>
                    <ul v-else>
                        <li>
                            <router-link to="/signup" class="hover:text-screamin-green duration-200"
                            >Register
                                <font-awesome-icon icon="fa-solid fa-user-plus"></font-awesome-icon
                                >
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/login" class="hover:text-screamin-green duration-200"
                            >Login
                                <font-awesome-icon icon="fa-solid fa-arrow-right-to-bracket"></font-awesome-icon
                                >
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import {ref, computed, watch} from 'vue'
import {useUserStore} from '../../stores/UserStore';
import router from '@/router'
import debounce from 'lodash.debounce'

const isMenuOpened = ref(false)
const isSearchBoxOpened = ref(false)

const userLogged = useUserStore()

const searchQuery = ref('')

const searchBoxQuery = ref(false)

const results = ref()

watch(() => searchQuery.value, debounce(() => {
    if (searchQuery.value === '') {
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
