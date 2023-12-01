<template>
    <header class="flex flex-col w-full text-lg font-mono border-b-2 border-primary-black shadow-sm shadow-secondary-black sticky top-0 start-0" x-data="{open: false, search: false}">
        <div class="top-0 w-full min-h-16 bg-secondary-white">
            <div class="flex md:flex-nowrap md:flex-row flex-col mx-4 h-full md:justify-normal items-center justify-between">
                <div class="flex flex-row justify-between items-center w-full h-16 md:w-auto">
                    <button @click="openSearch" class="md:hidden flex items-center justify-center p-3 w-10 h-10 bg-amber-400 hover:bg-amber-500 duration-200 border-2 border-primary-black shadow-sm shadow-secondary-black text-primary-black  rounded">
                        <font-awesome-icon :icon="['fa-solid', searchIcon]"></font-awesome-icon>
                    </button>

                    <router-link to="/" class="text-primary-black duration-200 hover:text-secondary-black text-2xl md:text-lg font-bold" href="/">WebApp</router-link>

                    <button @click="openMenu" class="md:hidden flex items-center justify-center p-3 w-10 h-10 bg-amber-400 hover:bg-amber-500 duration-200 border-2 border-primary-black shadow-sm shadow-secondary-black text-primary-black  rounded">
                        <font-awesome-icon :icon="['fa-solid', menuIcon]"></font-awesome-icon>
                    </button>
                </div>
                
                <!--Search Bar-->
                <div :class="isSearchBoxOpened ? 'flex' : 'hidden'" class="md:flex md:flex-nowrap items-center md:flex-row pb-2 md:pb-0 gap-8 md:w-96 w-full">
                    <div class="flex md:flex-nowrap w-full md:flex-[unset] md:w-96">
                        <form id="search_form" action="" method="post"></form>
                        <input form="search_form" class="md:ml-14 md:w-96 w-full rounded-l-md p-2 md:p-1 placeholder:font-semibold border-2 border-r-0 border-primary-black shadow-sm shadow-secondary-black" type="search" placeholder="Search...">
                        <button form="search_form" class="w-14 rounded-r-md duration-200 bg-amber-400 hover:bg-amber-500 border-2 border-primary-black shadow-sm shadow-secondary-black">
                            <font-awesome-icon icon="fa-solid fa-search"></font-awesome-icon>
                        </button>
                    </div>
                </div>
                
                <!--Navigation Bar-->
                <div class="flex flex-row items-center justify-center px-6">
                    <nav>
                        <ul class="flex flex-row gap-5 font-semibold text-primary-black">
                            <li class="hover:text-secondary-black duration-200">
                                <router-link to="/">Following</router-link>
                            </li>
                            <li class="hover:text-secondary-black duration-200">
                                <router-link to="/">Explore</router-link>
                            </li>
                        </ul>
                    </nav>
                
                </div>

                <div class="flex-1"></div>
                <button @click="openMenu" class="hidden md:flex items-center justify-center p-3 w-10 h-10 bg-amber-400 hover:bg-amber-500 duration-200 border-2 border-primary-black shadow-sm shadow-secondary-black text-primary-black rounded">
                        <font-awesome-icon v-bind:icon="['fa-solid', menuIcon]"></font-awesome-icon>
                </button>
            </div>
        </div>

        <!--User Menu-->
        <div v-if="isMenuOpened" dir="rtl" class="flex flex-col text-left start-4 fixed top-14 md:top-[55px] p-5 text-lg bg-secondary-white rounded-md border-2 border-primary-black shadow-sm shadow-secondary-black">
            <ul>
                <li>
                    <router-link to="/my-profile">My profile <font-awesome-icon icon="fa-solid fa-user"></font-awesome-icon></router-link>
                </li>
                <li>
                    <router-link to="/create">Create <font-awesome-icon icon="fa-solid fa-add"></font-awesome-icon></router-link>
                </li>
                <li>
                    <router-link to="/logout">Logout <font-awesome-icon icon="fa-solid fa-arrow-right-to-bracket"></font-awesome-icon></router-link>
                </li>
                <li>
                    <router-link to="/signup">Register <font-awesome-icon icon="fa-solid fa-user-plus"></font-awesome-icon></router-link>
                </li>
                <li>
                    <router-link to="/login">Login <font-awesome-icon icon="fa-solid fa-arrow-right-to-bracket"></font-awesome-icon></router-link>
                </li>
            </ul>
        </div>
    </header>
</template>

<script>
export default {
    name: 'NavBar',
    data() {
        return {
            webName: 'WebApp',
            isMenuOpened: false,
            isSearchBoxOpened: false,
        }
    },
    computed: {
        menuIcon() {
            if (this.isMenuOpened) {
                return 'fa-x'
            } else {
                return 'fa-bars'
            }
        },
        searchIcon() {
            if (this.isSearchBoxOpened) {
                return 'fa-x'
            } else {
                return 'fa-search'
            }
        }
    },
    methods: {
        openMenu() {
            this.isMenuOpened = !this.isMenuOpened;
        },
        openSearch() {
            this.isSearchBoxOpened = !this.isSearchBoxOpened;
        }
    } 
}
</script>
